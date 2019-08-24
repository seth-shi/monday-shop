<?php

namespace App\Admin\Controllers;

use App\Models\ScoreLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ScoreLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '积分日志';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ScoreLog);

        $grid->model()->latest();

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('user.name', '用户名');
        $grid->column('description', __('Description'));
        $grid->column('score', __('Score'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->disableActions();
        $grid->disableCreateButton();

        $grid->filter(function (Grid\Filter $filter) {

            $filter->like('user.name', '用户名');
            $filter->equal('score', '积分');
        });

        return $grid;
    }
}
