<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\OrderReceivedAction;
use App\Admin\Actions\Post\OrderRefundAction;
use App\Admin\Actions\Post\OrderShipAction;
use App\Admin\Extensions\ReceivedButton;
use App\Admin\Extensions\ShipButton;
use App\Admin\Transforms\OrderDetailTransform;
use App\Admin\Transforms\OrderPayTypeTransform;
use App\Admin\Transforms\OrderShipStatusTransform;
use App\Admin\Transforms\OrderStatusTransform;
use App\Admin\Transforms\OrderTypeTransform;
use App\Admin\Transforms\YesNoTransform;
use App\Enums\OrderShipStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yansongda\Pay\Pay;

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
            ->description('')
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
            ->description('')
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

        $grid->model()->withTrashed()->latest();

        $grid->column('id');
        $grid->column('no', '流水号');
        $grid->column('user.name', '用户');
        $grid->column('origin_amount', '订单原价');
        $grid->column('post_amount', '邮费');
        $grid->column('coupon_amount', '优惠');
        $grid->column('amount', '总价');
        $grid->column('status', '状态')->display(function ($status) {

            // 如果订单是付款, 那么就修改为物流状态
            if ($status == OrderStatusEnum::PAID) {

                return OrderShipStatusTransform::trans($this->ship_status);
            }

            return OrderStatusTransform::trans($status);
        });
        $grid->column('type', '订单类型')->display(function ($type) {

            return OrderTypeTransform::trans($type);
        });

        $grid->column('pay_type', '支付方式')->display(function ($type) {

            return OrderPayTypeTransform::trans($type);
        });
        $grid->column('pay_no', '支付流水号');
        $grid->column('paid_at', '支付时间');
        $grid->column('consignee_name', '收货人姓名');
        $grid->column('consignee_phone', '收货人手机');
        $grid->column('created_at', '创建时间');

        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->actions(function (Grid\Displayers\DropdownActions $actions) {

            /**
             * @var $order Order
             */
            $order = $actions->row;


            // 如果出现了申请,显示可以退款按钮
            if ($order->status == OrderStatusEnum::APPLY_REFUND) {

                $actions->add(new OrderRefundAction());
            } elseif ($order->status == OrderStatusEnum::PAID) {

                if ($order->ship_status == OrderShipStatusEnum::PENDING) {

                    $actions->add(new OrderShipAction());
                } elseif ($order->ship_status == OrderShipStatusEnum::DELIVERED) {

                    $actions->add(new OrderReceivedAction());
                }

            }

            $actions->disableEdit();
        });

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
        $show = new Show(Order::query()->withTrashed()->findOrFail($id));

        $show->field('id');
        $show->field('no', '流水号');
        $show->field('user', '用户')->as(function ($user) {
            return optional($user)->name;
        });


        $show->divider();

        $show->field('amount', '总计');
        $show->field('status', '状态')->as(function ($status) {

            // 如果订单是付款, 那么就修改为物流状态
            if ($status == OrderStatusEnum::PAID) {

                return OrderShipStatusTransform::trans($this->ship_status);
            }

            return OrderStatusTransform::trans($status);
        });
        $show->field('type', '订单类型')->as(function ($type) {

            return OrderTypeTransform::trans($type);
        });

        $show->divider();

        $show->field('express_company', '物流公司');
        $show->field('express_no', '物流单号');

        $show->divider();

        $show->field('consignee_name', '收货人');
        $show->field('consignee_phone', '收货人手机');
        $show->field('consignee_address', '收货地址');

        $show->divider();

        $show->field('pay_type', '支付类型')->as(function ($type) {

            return OrderPayTypeTransform::trans($type);
        });
        $show->field('refund_reason', '退款理由');
        $show->field('pay_trade_no', '退款单号');
        $show->field('pay_no', '支付单号');
        $show->field('paid_at', '支付时间');
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '修改时间');

        // 详情
        $show->details('详情', function (Grid $details) {

            $details->column('id');
            $details->column('product.name', '商品名字');
            $details->column('price', '单价');
            $details->column('number', '数量');
            $details->column('is_commented', '是否评论')->display(function ($is) {

                return YesNoTransform::trans($is);
            });
            $details->column('total', '小计');

            $details->disableRowSelector();
            $details->disableCreateButton();
            $details->disableFilter();
            $details->disableActions();
        });

        return $show;
    }

    /**
     * 后台删除订单就是真的删除了
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {

            DB::transaction(function () use ($id) {
                /**
                 * @var $order Order
                 */
                $order = Order::withTrashed()->findOrFail($id);
                $order->details()->delete();
                $order->forceDelete();
            });

            $data = [
                'status'  => true,
                'message' => trans('admin.delete_succeeded'),
            ];
        } catch (\Throwable $e) {
            $data = [
                'status'  => false,
                'message' => trans('admin.delete_failed') . $e->getMessage(),
            ];
        }

        return response()->json($data);
    }
}
