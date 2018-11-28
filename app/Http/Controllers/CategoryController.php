<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    /**
     * 前台分类列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::query()->latest()->paginate(30);


        return view('categories.index', compact('categories'));
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
        $categoryProducts = $category->products()->withCount('users')->orderBy($orderBy, 'desc')->paginate(10);


        return view('categories.show', compact('category', 'categoryProducts'));
    }
}
