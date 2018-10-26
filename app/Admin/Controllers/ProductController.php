<?php

namespace App\Admin\Controllers;


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
            ->description('description')
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

        $grid->model()->latest();

        $grid->column('id');
        $grid->column('category.title', '商品类别');
        $grid->column('name', '商品名')->limit(30);
        $grid->column('thumb', '首图')->display(function ($thumb) {
            return image($thumb);
        });
        $grid->column('price', '价格')->display(function ($price) {
            return $price . '/' . $this->price_original;
        });
        $grid->column('safe_count', '售出数量')->sortable();
        $grid->column('count', '库存量')->sortable();
        $grid->column('is_alive', '是否上架')->display(function ($isAlive) {
            return $isAlive ? '<mark>上架</mark>' : '<mark style="color: red">下架</mark>';
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
            return $price . '/' . $this->price_original;
        });
        $show->field('safe_count', '售出数量');
        $show->field('count', '库存量');
        $show->field('is_alive', '是否上架')->as(function ($isAlive) {
            return $isAlive ? '上架' : '下架';
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
        $form->currency('price_original', '原价')->symbol('$')->rules('required|numeric');
        $form->number('count', '库存量')->rules('required|integer|min:0');
        $form->switch('is_alive', '是否上架')->default(1);

        $form->image('thumb', '缩略图')->uniqueName()->move('products/thumb')->rules('required');
        $form->multipleImage('pictures', '轮播图')->uniqueName()->move('products/lists');

        $form->editor('detail.content', '详情')->rules('required');

        return $form;
    }
}
