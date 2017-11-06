<?php

namespace App\Http\Controllers\Home;

use App\Models\Category;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(30);


        return view('home.categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $categoryProducts = $category->products()->paginate(10);

        return view('home.categories.show', compact('category', 'categoryProducts'));
    }
}
