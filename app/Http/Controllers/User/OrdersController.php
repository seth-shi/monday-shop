<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\OrderDetail;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class OrdersController extends Controller
{

    public function index()
    {
        dd(1);
        return view('user.orders.index');
    }


    public function create()
    {
        return view('user.orders.index');
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


    public function show(Order $order)
    {
        //
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
}
