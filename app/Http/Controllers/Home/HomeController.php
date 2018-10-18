<?php

namespace App\Http\Controllers\Home;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * 首页显示的数据
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::query()->take(9)->get();
        $hotProducts = Product::query()->orderBy('safe_count', 'desc')->take(3)->get();
        $latestProducts = Product::query()->latest()->take(9)->get();
        $users = User::query()->orderBy('login_count', 'desc')->take(10)->get(['name', 'avatar']);

        return view('home.homes.index', compact('categories', 'hotProducts', 'latestProducts', 'users'));
    }
}
