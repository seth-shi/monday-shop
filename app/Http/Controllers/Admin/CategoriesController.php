<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;


class CategoriesController extends Controller
{
    private $categoryService;

    /**
     * 注入分类处理逻辑，主要作层级递归显示的
     *
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * 分类列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->categoryService->getTransformCategories();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * 创建分类页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = $this->categoryService->getTransformCategories();

        return view('admin.categories.create', compact('categories'));
    }

    /**
     * 创建分类处理逻辑
     *
     * @param CategoryRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        // 先把分类的图片处理
        if (! $link = $request->file('thumb')->store(config('web.upload.category'), 'public')) {

            return back()->withErrors(['thumb' => '文件上传失败']);
        }

        $data = $this->getRequestForm($request);
        $data['thumb'] = $link;

        // 是否是一级栏目
        if ($data['parent_id'] == '0') {
            Category::create($data);
        } else {
            /**
             * @var $category Category
             */
            $category = Category::query()->find($data['parent_id']);
            $category->children()->create($data);
        }

        return back()->with('status', '创建分类成功');
    }

    /**
     * 显示分类
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    /**
     * 编辑单个分类
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        $categories = $this->categoryService->getTransformCategories();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * 修改分类逻辑
     *
     * @param CategoryRequest $request
     * @param Category        $category
     * @return \Illuminate\Http\RedirectResponse
     */
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
     * 删除分类
     *
     * @param Category $category
     * @return array|\Illuminate\Http\RedirectResponse
     * @throws \Exception
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

    /**
     * 分类的表单信息获取
     *
     * @param Request $request
     * @return array
     *
     */
    private function getRequestForm(Request $request)
    {
        // add category pinyin
        $data = $request->only(['name', 'description', 'parent_id']);

        return $data;
    }
}
