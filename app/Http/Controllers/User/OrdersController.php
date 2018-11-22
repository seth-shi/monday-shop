<?php

namespace App\Http\Controllers\User;

use App\Events\CountSale;
use App\Exceptions\OrderException;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderMuiltRequest;
use App\Http\Requests\OrderRequest;
use App\Models\Address;
use App\Models\Car;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class OrdersController extends Controller
{

    public function index()
    {
        /**
         * @var $user User
         */
        $user = auth()->user();
        $orders = $user->orders()->with('details', 'details.product')->get();

        return view('user.orders.index', compact('orders'));
    }

    /**
     * 购物车批量下单
     *
     * @param  OrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(OrderRequest $request)
    {
        /**
         * @var $user User
         */
        $user = $request->user();
        $cars = $user->cars()->with('product')->get();

        if ($cars->isEmpty()) {
            return back()->withErrors(['address_id' => '购物车为空，请选择商品后再结账']);
        }

        try {

            DB::transaction(function () use ($request, $cars, $user) {

                // 主表
                $masterOrder = $this->newMasterOrder($request);
                // 明细表
                $details = $cars->map(function (Car $car) use ($masterOrder) {

                    // 库存量减少
                    $this->decProductNumber($car->product, $car->numbers);

                    $attribute =  [
                        'product_id' => $car->product_id,
                        'numbers' => $car->numbers
                    ];
                    $attribute['price'] = $car->product->price;
                    $attribute['total'] = ceilTwoPrice($attribute['price'] * $attribute['numbers']);
                    $masterOrder->total += $attribute['total'];


                    return $attribute;
                });
                $masterOrder->save();
                $details = $masterOrder->details()->createMany($details->all());
                // 删除购物车完成
                $user->cars()->delete();

                // 统计订单

            });

        } catch (\Exception $e) {
            return back()->with('status', $e->getMessage());
        }


        return back()->with('status', '下单成功');
    }

    /**
     * 库存数量
     *
     * @param Product $product
     * @param         $number
     * @throws OrderException
     */
    protected function decProductNumber(Product $product, $number)
    {
        if ($number > $product->count) {
            throw new OrderException("[{$product->name}] 库存数量不足");
        }

        $product->setAttribute('count', $product->count - $number)
                ->setAttribute('safe_count', $product->safe_count + $number)
                ->save();
    }


    /**
     * 实例化一个主订单
     * @param Request $request
     * @return Order
     */
    protected function newMasterOrder(Request $request)
    {
        /**
         * 主订单的新建
         * @var $address Address
         * @var $masterOrder Order
         */
        $address = Address::query()->find($request->input('address_id'));

        return  new Order(['address' => $address->format(), 'user_id' => auth()->id()]);
    }

    /**
     *
     * @param Request $request
     * @return array
     * @throws \Throwable
     */
    protected function single(Request $request)
    {

        if (! $this->hasAddress($request->input('address_id'))) {
            return response()->json(['code' => 400, 'msg' => '请选择正确的收货地址']);
        }

        try {
            DB::transaction(function () use ($request) {

                $number = $request->input('numbers', 1);

                /**
                 * @var $product Product
                 */
                $masterOrder = $this->newMasterOrder($request);

                $product = Product::query()
                                  ->where('uuid', $request->input('product_id'))
                                  ->firstOrFail();

                // 库存数量
                $this->decProductNumber($product, $number);

                $detail = [
                    'numbers' => $number,
                    'product_id' => $product->id,
                    'price' => $product->price,
                ];
                $detail['total'] = ceilTwoPrice($detail['numbers'] * $detail['price']);
                $masterOrder->total = $detail['total'];
                $masterOrder->save();
                $detail = $masterOrder->details()->create($detail);

                // 统计订单

            });
        } catch (\Exception $e) {

            return response()->json(['code' => 400, 'msg' => $e->getMessage()]);
        }

        return [
            'code' => 200,
            'msg' => '购买成功'
        ];
    }


    public function show(Order $order)
    {


        if ($order->user_id != Auth::user()->id) {
            abort(403, '你没有权限');
        }

        return view('user.orders.show', compact('order'));
    }


    /**
     * 地址是否存在
     *
     * @param $address
     * @return bool
     */
    protected function hasAddress($address)
    {
        return Address::query()
                      ->where('user_id', auth()->id())
                      ->where('id', $address)
                      ->exists();
    }


    public function destroy($id)
    {
        $order = Order::query()->findOrFail($id);
        // 判断是当前用户的订单才可以删除
        if (auth()->id() != $order->user_id) {
            abort(403);
        }

        $order->delete();

        return back()->with('status', '删除成功');
    }

}
