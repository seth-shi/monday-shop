<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class CommentController extends Controller
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
            ->header('评论列表')
            ->description('')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Comment);

        $grid->model()->latest();

        $grid->column('id');
        $grid->column('order_id', '订单');
        $grid->column('product.name', '商品');
        $grid->column('user.name', '用户');
        $grid->column('content', '评论内容');
        $grid->column('score', '评分');
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '修改时间');

        $grid->filter(function (Grid\Filter $filter) {

            $filter->disableIdFilter();
            $filter->where(function ($query) {

                $collections = User::query()
                                   ->where('name', 'like', "%{$this->input}%")
                                   ->pluck('id');
                $query->whereIn('user_id', $collections->all());
            }, '用户');
            $filter->where(function ($query) {

                $collections = Product::query()
                                      ->where('name', 'like', "%{$this->input}%")
                                      ->pluck('id');

                $query->whereIn('product_id', $collections->all());
            }, '商品');
        });

        return $grid;
    }
}
