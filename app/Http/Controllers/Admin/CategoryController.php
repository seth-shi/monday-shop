<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreCategoryPost;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categorys = $this->categoryRepository->getAllWithDepath();

        return view('admin.category.index', compact('categorys'));
    }

    public function create()
    {
        $categorys = $this->categoryRepository->getAllWithDepath();

        return view('admin.category.add', compact('categorys'));
    }

    public function store(StoreCategoryPost $request)
    {
        $fileds = $request->only(['parent_id', 'name', 'description']);

        if ($this->categoryRepository->create($fileds)) {
            return back()->with('status', '创建分类成功');
        } else {
            return back()->withInput()->with('status', '服务器忙，请稍后再试');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
