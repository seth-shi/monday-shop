<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Show;
use Encore\Admin\Tree;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('商品分类')
            ->description('description')
            ->row(function (Row $row) {

                // 只能在同一级排序拖动，不允许二级
                $row->column(6, Category::tree(function (Tree $tree) {
                    $tree->disableCreate();

                    $tree->nestable(['maxDepth' => 1]);
                }));

                // 新建
                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_base_path('categories'));

                    $form->text('title', '分类名')->rules('required|unique:categories,title');
                    $form->icon('icon', '图标')->default('fa-bars')->rules('required');
                    $form->image('thumb', '缩略图')->uniqueName()->rules('required');
                    $form->hidden('_token')->default(csrf_token());

                    $column->append((new Box('新增', $form))->style('success'));
                });
            });
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('详情')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑')
            ->description('description')
            ->body($this->form()->edit($id));
    }



    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Category::findOrFail($id));

        $show->field('id');
        $show->field('title', '分类名');
        $show->field('thumb', '缩略图')->unescape()->as(function ($thumb) {
            return imageUrl($thumb);
        });
        $show->field('description', '描述');
        $show->field('order', '排序');
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '修改时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category);

        $form->text('title', '分类名');
        $form->image('thumb', '缩略图');
        $form->text('description', '描述');

        return $form;
    }


    /**
     * 分类下有商品，不允许删除
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        /**
         * @var $category Category
         */
        $category = Category::query()->findOrFail($id);

        if ($category->products()->exists()) {
            return response()->json(['status' => false, 'message' => '分类下有商品存在，不允许删除']);
        }

        if ($category->delete()) {
            $data = [
                'status'  => true,
                'message' => trans('admin.delete_succeeded'),
            ];
        } else {
            $data = [
                'status'  => false,
                'message' => trans('admin.delete_failed'),
            ];
        }

        return response()->json($data);
    }
}
