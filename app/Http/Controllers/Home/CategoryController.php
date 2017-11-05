<?php

namespace App\Http\Controllers\Home;

use App\Models\Category;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::groupBy('pinyin');

            dd($categories);
        return view('home.categories.index');
    }

    public function show(Category $category)
    {
        $categoryProducts = $category->products()->paginate(10);

        return view('home.categories.show', compact('category', 'categoryProducts'));
    }
}
