<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;


class CategoriesController extends Controller
{
    /**
     * 前台分类列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::query()->latest()->paginate(30);


        return view('home.categories.index', compact('categories'));
    }

    /**
     * 分类详情
     *
     * @param Request  $request
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Category $category)
    {
        $orderBy = $request->input('orderBy', 'created_at');
        $categoryProducts = $category->products()->orderBy($orderBy, 'desc')->paginate(10);


        return view('home.categories.show', compact('category', 'categoryProducts'));
    }
}
