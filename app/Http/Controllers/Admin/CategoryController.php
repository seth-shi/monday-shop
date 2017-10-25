<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreCategoryPost;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = $this->getTransformCategories();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = $this->getTransformCategories();

        return view('admin.categories.create', compact('categories'));
    }

    public function store(StoreCategoryPost $request)
    {
        $parent_id = $request->input('parent_id');

        // create a root tree
        if ($request->input('parent_id') == '0') {
            Category::create($request->all());
        } else {
            Category::find($parent_id)->children()->create($request->all());
        }

        return back()->with('status', '创建分类成功');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $categories = $this->getTransformCategories();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(StoreCategoryPost $request, Category $category)
    {
        $category->parent_id = $request->input('parent_id');
        $category->name = $request->input('name');
        $category->description = $request->input('description');

        if ($category->save()) {
            return back()->with('status', '修改成功');
        } else {
            return back()->with('status', '服务器出错，请稍后再试');
        }
    }

    public function destroy(Category $category)
    {
        $response = ['errno' => 1, 'errmsg' => '删除失败'];

        if ($category->delete()) {
            $response['errno'] = 0;
            $response['errmsg'] = "{$category->name} 删除成功";
        }

        if(request()->ajax()) {
            return $response;
        }

        return back()->with('status', $response['errmsg']);
    }

    private function getTransformCategories()
    {
        $categories = Category::defaultOrder()->withDepth()->get();

        $categories->transform(function ($category) {

            $category->className = (str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category->depth)) . ($category->ancestors->count() ? '┣━━ ' : ' ') . $category->name;

            $category->parentClass = $category->isRoot() ? '一级分类' : implode(' ➤ ', $category->ancestors->pluck('name')->toArray());

            return $category;
        });

        return $categories;
    }
}
