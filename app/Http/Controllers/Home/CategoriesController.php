<?php

namespace App\Http\Controllers\Home;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(30);


        return view('home.categories.index', compact('categories'));
    }

    public function show(Request $request, Category $category)
    {
        $orderBy = $request->input('orderBy', 'created_at');
        $categoryProducts = $category->products()->orderBy($orderBy, 'desc')->paginate(10);


        return view('home.categories.show', compact('category', 'categoryProducts'));
    }
}
