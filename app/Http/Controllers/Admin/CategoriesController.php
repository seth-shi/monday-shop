<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Pinyin;


class CategoriesController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getTransformCategories();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = $this->categoryService->getTransformCategories();

        return view('admin.categories.create', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        // move file to public
        if (! $link = $request->file('thumb')->store(config('web.upload.category'), 'public')) {

            return back()->withErrors(['thumb' => '文件上传失败']);
        }

        $data = $this->getRequestForm($request);
        $data['thumb'] = $link;

        // create a root tree
        if ($data['parent_id'] == '0') {
            Category::create($data);
        } else {

            Category::find($data['parent_id'])->children()->create($data);
        }

        return back()->with('status', '创建分类成功');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $categories = $this->categoryService->getTransformCategories();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $data = $this->getRequestForm($request);

        if ($category->update($data)) {
            return back()->with('status', '修改成功');
        } else {
            return back()->with('status', '服务器出错，请稍后再试');
        }
    }

    /**
     * single delete is post submit, batch delete is ajax.
     * @param Category $category
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $response = ['code' => 1, 'msg' => '删除失败'];

        try {
            if ($category->delete()) {

                // delete products
                $response['code'] = 0;
                $response['msg'] = "{$category->name} 删除成功";
            }
        } catch (QueryException $e) {
            $response['code'] = 2;
            $response['msg'] = "{$category->name} 分类下有商品存在，不允许直接删除";
        }


        if(request()->ajax()) {
            return $response;
        }

        return back()->with('status', $response['msg']);
    }

    private function getRequestForm(Request $request)
    {
        // add category pinyin
        $data = $request->only(['name', 'description', 'parent_id']);

        return $data;
    }
}
