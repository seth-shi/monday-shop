<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
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
        // cars to orders
        $cars = $request->user()->cars()->with('product')->get();

        $order_data = $this->formatOrderData($request, $cars);
        $order = $request->user()->orders()->create($order_data);

        // create order detail table
        // 'numbers', 'product_id', 'order_id'
        $order_detail_data = [];
        foreach ($cars as $car) {
            $order_detail_data[] = [
                'order_id' => $order->id,
                'product_id' => $car['product_id'],
                'numbers' => $car['numbers']

            ];
        }

        OrderDetail::insert($order_detail_data);

        // delete cars data
        $request->user()->cars()->delete();

        return back()->with('status', '下单成功');
    }


    protected function single(Request $request)
    {
        // cars to orders
        $order_data = $this->formatSingleData($request);

        $order = $request->user()->orders()->create($order_data);

        $detail_data = [
            'numbers' => $request->input('numbers'),
            'product_id' => $request->input('product_id'),
            'order_id' => $order->id,
        ];
        OrderDetail::create($detail_data);

        return [
            'code' => 0,
            'msg' => '购买成功'
        ];
    }

    public function show(Order $order)
    {
        if ($order->user_id != Auth::user()->id) {
            abort(404, '你没有权限');
        }

        return view('user.orders.show', compact('order'));
    }


    public function edit(Order $order)
    {
        //
    }


    public function update(Request $request, Order $order)
    {
        //
    }


    public function destroy(Order $order)
    {
        //
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
