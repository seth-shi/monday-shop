<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\OrderMuiltRequest;
use App\Models\Address;
use App\Models\Car;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class OrdersController extends Controller
{

    public function index()
    {
        $orders = Auth::user()->orders;

        return view('user.orders.index', compact('orders'));
    }

    /**
     * 购物车批量下单
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(OrderMuiltRequest $request)
    {
        /**
         * @var $user User
         */
        $user = $request->user();
        $cars = $user->cars()->with('product')->get();

        if ($cars->isEmpty()) {
            return back()->withErrors(['address_id' => '购物车为空，请选择商品后再结账']);
        }

        // begin tran
        DB::beginTransaction();


        $masterOrder = $this->newMasterOrder($request);

        $details = $cars->map(function (Car $car) use ($masterOrder) {

            $attribute =  [
                'product_id' => $car->product_id,
                'numbers' => $car->numbers
            ];
            $attribute['price'] = $car->product->price;
            $attribute['total'] = ceilTwoPrice($attribute['price'] * $attribute['numbers']);
            $masterOrder->total += $attribute['total'];

            return $attribute;
        });

        if (! $masterOrder->save()) {
            DB::rollBack();
            return back()->with('status', '服务器异常，请稍后再试');
        }

        // 订单明细
        if (! $masterOrder->details()->createMany($details->all())) {
            DB::rollBack();
            return back()->with('status', '服务器异常，请稍后再试');
        }

        // 删除购物车完成
        $user->cars()->delete();

        DB::commit();
        return back()->with('status', '下单成功');
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
     * 单个商品下单
     *
     * @param Request $request
     * @return array
     */
    protected function single(Request $request)
    {

        if ($this->isGreaterStock($request->all())) {
            return [
                'code' => 302,
                'msg' => '购买的数量大于库存量'
            ];
        }

        // cars to orders
        $order_data = $this->formatSingleData($request);

        $order = $request->user()->orders()->create($order_data);

        $detail_data = [
            'numbers' => $request->input('numbers'),
            'product_id' => $request->input('product_id'),
            'order_id' => $order->id,
        ];
        OrderDetail::create($detail_data);


        // Reduce inventory
        ProductDetail::where('product_id', $detail_data['product_id'])
            ->lockForUpdate()
            ->first()
            ->decrement('count', $detail_data['numbers']);

        return [
            'code' => 0,
            'msg' => '购买成功'
        ];
    }

    /**
     * check buy number is greater stock numbers
     * @param array $data
     * @return array
     */
    protected function isGreaterStock(array $data)
    {
        // buy numbers > count
        $product = Product::find($data['product_id']);

        if ($data['numbers'] > $product->productDetail->count) {
            return true;
        }

        return false;
    }

    public function show(Order $order)
    {
        if ($order->user_id != Auth::user()->id) {
            abort(404, '你没有权限');
        }

        return view('user.orders.show', compact('order'));
    }




    private function formatSingleData($request)
    {
        $product_id = $request->input('product_id');
        $numbers = $request->input('numbers');
        $address_id = $request->input('address_id');
        $uuid = Uuid::generate()->hex;
        $total = Product::find($product_id)->price * $numbers;

        return compact('product_id', 'total', 'uuid', 'address_id');
    }


}
