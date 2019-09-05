<?php

namespace App\Admin\Controllers;

use App\Admin\Transforms\YesNoTransform;
use App\Models\UserHasCoupon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CouponLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '会员领取记录';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserHasCoupon);

        $grid->model()->latest();

        $grid->column('id', __('Id'));
        $grid->column('user_id', '用户 ID');
        $grid->column('user.name', '用户昵称');
        $grid->column('title', __('Title'));
        $grid->column('amount', '满减金额');
        $grid->column('full_amount', __('Full amount'));
        $grid->column('start_date', __('Start date'));
        $grid->column('end_date', __('End date'));
        $grid->column('is_used', '是否使用')->display(function () {

            return YesNoTransform::trans(! is_null($this->used_at));
        });
        $grid->column('used_at', '使用时间');
        $grid->column('created_at', __('Created at'));

        $grid->disableActions();
        $grid->disableCreateButton();

        $grid->filter(function (Grid\Filter $filter) {

            $filter->like('title', __('Title'));
        });

        return $grid;
    }
}
