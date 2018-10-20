<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OrderController extends Controller
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
            ->header('订单列表')
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
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        $grid->model()->latest();
        // TODO
        $grid->column('id');
        $grid->column('no', '流水号');
        $grid->column('user.name', '用户');
        $grid->column('total', '总价');
        $grid->column('status', '状态');
        $grid->column('address', '收货地址');
        $grid->column('pay_no', '支付流水号');
        $grid->column('pay_time', '支付时间');
        $grid->column('pay_type', '支付类型');
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '修改时间');

        $grid->disableCreateButton();
        $grid->filter(function (Filter $filter) {

            $filter->disableIdFilter();
            $filter->like('no', '流水号');
            $filter->where(function ($query) {

                $users = User::query()->where('name', 'like', "%{$this->input}%")->pluck('id');
                $query->whereIn('user_id', $users->all());
            }, '用户');
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
        $show = new Show(Order::findOrFail($id));

        $show->id('Id');
        $show->no('No');
        $show->user_id('User id');
        $show->total('Total');
        $show->status('Status');
        $show->address('Address');
        $show->pay_no('Pay no');
        $show->pay_time('Pay time');
        $show->pay_type('Pay type');
        $show->deleted_at('Deleted at');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order);

        $form->text('no', 'No');
        $form->number('user_id', 'User id');
        $form->decimal('total', 'Total');
        $form->switch('status', 'Status');
        $form->textarea('address', 'Address');
        $form->text('pay_no', 'Pay no');
        $form->datetime('pay_time', 'Pay time')->default(date('Y-m-d H:i:s'));
        $form->switch('pay_type', 'Pay type');

        return $form;
    }
}
