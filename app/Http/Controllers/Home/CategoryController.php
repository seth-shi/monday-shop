<?php

namespace App\Http\Controllers\Home;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        //
    }

    public function show(Category $category)
    {
        $categoryProducts = $category->products()->paginate(10);

        return view('home.categories.show', compact('category', 'categoryProducts'));
    }
}
