<?php

namespace App\Admin\Controllers;

use App\Models\Car;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CarController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '购物车数据';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Car);

        $grid->column('id', __('Id'));

        $grid->column('user_id', __('User id'));
        $grid->column('product_id', __('Product id'));

        $grid->column('user.name', '用户');
        $grid->column('product.name', '商品');
        $grid->column('number', __('Number'));


        $grid->column('created_at', '收藏时间');

        $grid->disableActions();
        $grid->disableCreateButton();

        $grid->filter(function (Grid\Filter $filter) {

            $filter->equal('user_id', '用户ID');
            $filter->equal('product_id', '商品ID');
            $filter->like('user.name', '用户名');
            $filter->like('product.name', '商品');
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
        $show = new Show(Car::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('number', __('Number'));
        $show->field('product_id', __('Product id'));
        $show->field('user_id', __('User id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Car);

        $form->number('number', __('Number'))->default(1);
        $form->number('product_id', __('Product id'));
        $form->number('user_id', __('User id'));

        return $form;
    }
}
