<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Seckill;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
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
        // 如没有 key，存入缓存中，防止用户未配置好任务调度确访问首页
        // 数据将不会从首页更新，每分钟任务调度更新，请务必配置好
        $categories = Cache::rememberForever('home:categories', function () {

            return Category::query()->withCount('products')->orderBy('order')->take(9)->get();
        });
        $hotProducts = Cache::rememberForever('home:hottest', function () {

            return Product::query()->withCount('users')->orderBy('safe_count', 'desc')->take(3)->get();
        });
        $latestProducts = Cache::rememberForever('home:latest', function () {

            return Product::query()->withCount('users')->latest()->take(9)->get();
        });
        $users = Cache::rememberForever('home:users', function () {

            return User::query()->orderBy('login_count', 'desc')->take(10)->get(['avatar', 'name']);
        });

        // 秒杀数据
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



        /**
         * 当前登录用户
         *
         * @var $loginUser User
         */
        if ($loginUser = auth()->user()) {

            $loginUser->load('subscribe');
        }

        return view(
            'homes.index',
            compact('categories', 'hotProducts', 'latestProducts', 'users', 'secKills', 'loginUser')
        );
    }
}
