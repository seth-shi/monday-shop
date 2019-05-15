<?php

namespace App\Admin\Controllers;


use App\Admin\Transforms\ProductTransform;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProductController extends Controller
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
            ->header('商品列表')
            ->description('')
            ->body($this->grid());
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
            ->description('')
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
            ->description('')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('添加商品')
            ->description('为你的商城添加一个商品')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product);

        $grid->model()->withTrashed()->latest();

        $grid->column('id');
        $grid->column('category.title', '商品类别');
        $grid->column('name', '商品名')->display(function ($name) {
            return str_limit($name, 30);
        });
        $grid->column('thumb', '首图')->image('', 50, 50);
        $grid->column('price', '价格')->display(function ($price) {

            return $price . '/' . $this->original_price;
        });
        $grid->column('view_count', '浏览次数')->sortable();
        $grid->column('sale_count', '售出数量')->sortable();
        $grid->column('count', '库存量')->sortable();
        $grid->column('deleted_at', '是否上架')->display(function ($isAlive) {

            return ProductTransform::getInstance()->transDeleted($isAlive);
        });
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '修改时间');


        // 查询过滤
        $grid->filter(function (Grid\Filter $filter) {

            $categories = Category::query()
                                  ->orderBy('order')
                                  ->latest()
                                  ->pluck('title', 'id')
                                  ->all();

            $filter->disableIdFilter();
            $filter->equal('category_id', '分类')->select($categories);
            $filter->like('name', '商品名字');

        });

        // 增加一个上架，下架功能
        $grid->actions(function (Grid\Displayers\Actions $actions) {

            $id = $actions->row->id;
            $pushUrl = admin_url("products/{$id}/push");

            $link = is_null($actions->row->deleted_at) ?
                "<a class='btn btn-xs btn-warning fa fa-close' href='{$pushUrl}'>下架</a>":
                "<a class='btn btn-xs btn-success fa fa-check' href='{$pushUrl}'>上架</a>";

            $actions->prepend($link);
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Product::query()->findOrFail($id));

        $show->field('id');
        $show->field('category.title', '商品类别');
        $show->field('name', '商品名');
        $show->field('title', '卖点');
        $show->field('thumb', '缩略图')->image();
        $show->field('price', '价格')->as(function ($price) {
            return $price . '/' . $this->original_price;
        });
        $show->field('view_count', '浏览次数');
        $show->field('sale_count', '售出数量');
        $show->field('count', '库存量');
        $show->field('deleted_at', '是否上架')->as(function ($isAlive) {
            return is_null($isAlive) ? '上架' : '下架';
        });
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
        $form = new Form(new Product);


        $form->select('category_id', '类别')->options(Category::selectOrderAll())->rules('required|exists:categories,id');
        $form->text('name', '商品名字')->rules(function (Form $form) {

            $rules = 'required|max:50|unique:products,name';
            if ($id = $form->model()->id) {
                $rules .= ',' . $id;
            }

            return $rules;
        });
        $form->textarea('title', '卖点')->rules('required|max:199');
        $form->currency('price', '销售价')->symbol('$')->rules('required|numeric');
        $form->currency('original_price', '原价')->symbol('$')->rules('required|numeric');
        $form->number('count', '库存量')->rules('required|integer|min:0');

        $form->image('thumb', '缩略图')->uniqueName()->move('products/thumb')->rules('required');
        $form->multipleImage('pictures', '轮播图')->uniqueName()->move('products/lists');

        $form->editor('detail.content', '详情')->rules('required');

        return $form;
    }


    public function destroy($id)
    {
        $product = Product::query()->findOrFail($id);

        if ($product->forceDelete()) {
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

    /**
     * 上下架商品
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function pushProduct($id)
    {
        /**
         * @var $product Product
         */
        $product = Product::withTrashed()->findOrFail($id);


        // 如果商品已经下架
        if ($product->trashed()) {

            // 重新上架
            $product->restore();

            admin_toastr('上架成功');

            return redirect()->back();
        }


        $product->delete();

        admin_toastr('下架成功');

        return redirect()->back();
    }
}
