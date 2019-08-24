<?php

namespace App\Admin\Controllers;

use App\Models\ProductHasUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductLikeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品喜好';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ProductHasUser);

        $grid->model()->latest();

        $grid->column('user_id', __('User id'));
        $grid->column('product_id', __('Product id'));

        $grid->column('user.name', '用户');
        $grid->column('created_at', '收藏时间');
        $grid->column('product.name', '商品');
        $grid->column('product.price', '价格')->display(function ($price) {

            return $price . '/' . $this->product['original_price'];
        });
        $grid->column('product.thumb', '首图')->image('', 50, 50);


        $grid->disableActions();
        $grid->disableCreateButton();
        $grid->disableBatchActions();

        $grid->filter(function (Grid\Filter $filter) {

            $filter->disableIdFilter();
            $filter->like('user_id', '用户ID');
            $filter->like('product_id', '商品ID');
            $filter->like('user.name', '用户名');
            $filter->equal('product.name', '商品');
        });

        return $grid;
    }
}
