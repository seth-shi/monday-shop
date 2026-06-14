<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'users' => User::query()->count(),
            'products' => Product::withTrashed()->count(),
            'orders' => Order::query()->count(),
            'revenue' => Order::query()->whereIn('status', [OrderStatusEnum::PAID, OrderStatusEnum::COMPLETED])->sum('pay_amount'),
        ];

        $orders = Order::query()->with('user')->latest()->limit(8)->get();

        return view('admin.dashboard', compact('stats', 'orders'));
    }
}
