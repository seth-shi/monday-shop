<?php

namespace App\Http\Controllers\Home;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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

        return view('home.homes.index', compact('categories', 'hotProducts', 'latestProducts', 'users'));
    }
}
