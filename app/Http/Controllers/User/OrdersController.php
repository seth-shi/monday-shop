<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductDetail;
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

    public function store(Request $request)
    {
        $this->validate($request, ['address_id' => 'required'], ['address_id.required' => '收货地址不能为空']);

        // cars to orders
        $cars = $request->user()->cars()->with('product')->get();

        if ($cars->isEmpty()) {
            return back()->withErrors(['address_id' => '购物车为空，请选择商品后再结账']);
        }

        // begin tran
        DB::beginTransaction();
        $order_data = $this->formatOrderData($request, $cars);

        if ($order = $request->user()->orders()->create($order_data)) {
            DB::rollBack();
            return back()->with('status', '服务器异常，请稍后再试');
        }

        // 'numbers', 'product_id', 'order_id'
        $order_detail_data = [];
        foreach ($cars as $car) {
            $order_detail_data[] = [
                'order_id' => $order->id,
                'product_id' => $car['product_id'],
                'numbers' => $car['numbers']

            ];
        }

        if (! OrderDetail::insert($order_detail_data)) {
            DB::rollBack();
            return back()->with('status', '服务器异常，请稍后再试');
        }

        // delete cars data
        $request->user()->cars()->delete();

        DB::commit();
        return back()->with('status', '下单成功');
    }


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

    private function formatOrderData($request, $cars)
    {
        $total = $this->getTotal($cars);
        $uuid = Uuid::generate()->hex;
        $address_id = $request->input('address_id');

        return compact('total', 'uuid', 'address_id');
    }

    private function getTotal($cars)
    {
        $total = 0;

        foreach ($cars as $car) {
            $total += $car['numbers'] * $car['product']['price'];
        }

        return $total;
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
