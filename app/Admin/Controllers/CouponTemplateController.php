<?php

namespace App\Admin\Controllers;

use App\Admin\Transforms\YesNoTransform;
use App\Models\CouponTemplate;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CouponTemplateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '优惠券';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CouponTemplate);

        $grid->model()->latest('start_date');

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('amount', '优惠金额');
        $grid->column('full_amount', __('Full amount'));
        $grid->column('score', '需兑换积分');
        $grid->column('exp_date', '有效日期')->display(function () {

            return $this->start_date . ' ~ ' . $this->end_date;
        });
        $today = Carbon::today();
        $grid->column('overtime', '是否有效（未过期）')->display(function () use ($today) {

            $endDate = Carbon::make($this->end_date);
            $startDate = Carbon::make($this->start_date);
            // 如果没有结束日期，代表永远不过期
            if (is_null($endDate) || is_null($startDate)) {

                $isOver = true;
            } else {

                $isOver = $today->gte($startDate) && $today->lte($endDate);
            }

            return YesNoTransform::trans($isOver);
        });
        $grid->column('created_at', __('Created at'));

        $grid->filter(function (Grid\Filter $filter) {

            $filter->like('title', __('Title'));
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
        $form = new Form(new CouponTemplate);

        $form->text('title', __('Title'));
        $form->decimal('amount', '优惠金额');
        $form->decimal('full_amount', __('Full amount'));
        $form->number('score', __('Score'))->default(0)->help('设置为 0 代表无需积分即可兑换优惠券');
        $form->date('start_date', __('Start date'))->default(date('Y-m-d'));
        $form->date('end_date', __('End date'))->default(Carbon::today()->addMonth());

        return $form;
    }
}
