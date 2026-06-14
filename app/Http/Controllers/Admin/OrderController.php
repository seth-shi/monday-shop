<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderShipStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Support\OrderPresenter;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()->with('user')->when($request->filled('q'), fn ($query) => $query->where('no', 'like', '%'.$request->string('q').'%'))->latest('id')->paginate(20)->withQueryString();
        $orders->getCollection()->each(fn (Order $order) => $order->status_text = OrderPresenter::status($order));
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'details.product');
        $order->status_text = OrderPresenter::status($order);
        return view('admin.orders.show', compact('order'));
    }

    public function ship(Request $request, Order $order)
    {
        abort_unless((int) $order->status === OrderStatusEnum::PAID, 422, '只有已付款订单可以发货');
        $data = $request->validate(['express_company' => ['required', 'string', 'max:100'], 'express_no' => ['required', 'string', 'max:100']]);
        $order->forceFill($data + ['ship_status' => OrderShipStatusEnum::DELIVERED])->save();
        return back()->with('status', '物流信息已保存');
    }
}
