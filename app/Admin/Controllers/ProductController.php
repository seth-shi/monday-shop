<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ProductAlive;
use App\Admin\Extensions\ProductAttribute;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SuppoertCollection;

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
            ->header('Detail')
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
            ->header('Edit')
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
            ->header('Create')
            ->description('description')
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

        $grid->column('id');
        $grid->column('category.title', '商品类别');
        $grid->column('name', '商品名')->limit(30);
        $grid->column('thumb')->display(function ($thumb) {
            return imageUrl($thumb);
        });
        $grid->column('price', '价格')->display(function ($price) {
            return $price . '/' . $this->price_original;
        });
        $grid->column('safe_count', '售出数量')->sortable();
        $grid->column('count', '库存量')->sortable();
        $grid->column('is_alive', '是否上架')->display(function ($isAlive) {
            return $isAlive ? '上架' : '下架';
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
        $show = new Show(Product::with('attributes')->findOrFail($id));

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

        $show->divider();
        // 属性
        $show->field('attributes', '属性')->unescape()->as(function (Collection $attributes) {

            return new ProductAttribute($attributes);
        });

        $show->divider();


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


        $form->select('category_id', '类别')->options(Category::selectOrderAll());
        $form->text('name', '商品名字');
        $form->textarea('title', '卖点');
        $form->currency('price', '销售价')->symbol('$');
        $form->currency('price_original', '原价')->symbol('$');
        $form->image('thumb', '缩略图')->uniqueName()->move('products/thumb');
        $form->switch('is_alive', '是否上架')->default(1);

        $form->multipleImage('pictures', '轮播图')->uniqueName()->move('products/lists');

        $form->hasMany('attributes', '属性', function (Form\NestedForm $form) {

            $form->text('attribute', '属性');
            $form->text('value', '值');
            $form->currency('markup', '加价')->symbol('$');
        });


        $form->editor('detail.content', '详情');


        return $form;
    }
}
