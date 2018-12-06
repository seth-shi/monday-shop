<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Seckill;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class SeckillController extends Controller
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
            ->header('秒杀列表')
            ->description('description')
            ->body($this->grid());
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
            ->header('新建秒杀')
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
        $grid = new Grid(new Seckill);

        $grid->column('id');

        $grid->column('product.id', '商品ID');
        $grid->column('product.name', '商品名字')->display(function ($name) {
            return str_limit($name, 30);
        });
        $grid->column('product.thumb', '商品图')->display(function ($thumb) {
            return image($thumb);
        });

        $grid->column('numbers', '秒杀数量');
        $grid->column('start_at', '开始时间');
        $grid->column('end_at', '结束时间');
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '修改时间');

        $grid->actions(function (Grid\Displayers\Actions $actions) {

            $actions->disableView();
            $actions->disableEdit();
        });

        return $grid;
    }



    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Seckill);

        $categories = Category::selectOrderAll();
        $form->select('category_id', '分类')
             ->options($categories)
             ->load('product_id', admin_url('api/products'));
        $form->select('product_id', '秒杀商品');

        $form->number('numbers', '秒杀数量')->default(1)->help('保证商品的库存数量大于此数量，会从库存中减去');

        $now = Carbon::now();
        $form->datetime('start_at', '开始时间')->default($now->format('Y-m-d H:00:00'));
        $form->datetime('end_at', '结束时间')->default($now->addHour(1)->format('Y-m-d H:00:00'));

        return $form;
    }



    public function store(Request $request)
    {
        $numbers = $request->input('numbers', 0);
        $product = Product::query()->firstOrFail($request->input('product_id'));


        if ($numbers > $product->numbers) {

            return back()->withInput()->withErrors('秒杀数量不能大于库存数量');
        }


        return $this->form()->store();
    }
}
