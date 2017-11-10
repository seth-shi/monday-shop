<?php

namespace App\Http\Controllers\Home;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('parent_id', 'desc')->take(9)->get();
        $hotProducts = Product::orderBy('safe_count', 'desc')->take(3)->get();
        $latestProducts = Product::latest()->take(9)->get();
        $users = User::orderBy('login_count', 'desc')->take(10)->get(['name', 'avatar']);

        return view('home.homes.index', compact('categories', 'hotProducts', 'latestProducts', 'users'));
    }
}
