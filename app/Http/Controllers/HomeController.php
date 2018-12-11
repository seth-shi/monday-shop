<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Seckill;
use App\Models\User;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    /**
     * 首页显示的数据
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // 取出后台排序好的九个分类，并且关联出商品的总数
        $categories = Category::query()->withCount('products')->orderBy('order')->take(9)->get();
        $hotProducts = Product::query()->withCount('users')->orderBy('safe_count', 'desc')->take(3)->get();
        $latestProducts = Product::query()->withCount('users')->latest()->take(9)->get();
        $users = User::query()->orderBy('login_count', 'desc')->take(10)->get(['avatar', 'name']);


        $secKills = collect()->when(setting('is_open_seckill') == 1, function () {

            // 只要秒杀没有结束，都要查出来
            $now = Carbon::now()->toDateTimeString();
            $secKills = Seckill::query()
                               ->where('end_at', '>=', $now)
                               ->where('numbers', '>', 0)
                               ->oldest('start_at')
                               ->with('product')
                               ->get();

            return $secKills;
        });

        return view(
            'homes.index',
            compact('categories', 'hotProducts', 'latestProducts', 'users', 'secKills')
        );
    }
}
