<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ReceivedButton;
use App\Admin\Extensions\ShipButton;
use App\Admin\Transforms\OrderDetailTransform;
use App\Admin\Transforms\OrderTransform;
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
        Admin::js('/assets/admin/lib/layer/2.4/layer.js');


        $baseUrl = admin_url();
        // 发货表单
        $shipForm = new Form();
        $shipForm->method('post')
                 ->action($baseUrl)
                 ->attribute(['id' => 'ship_form', 'style' => 'display:none;'])
                 ->disablePjax();


        return $content
            ->header('订单列表')
            ->description('')
            ->body($this->grid())
            ->row($shipForm->render());
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
        $grid->column('total', '总价');
        $grid->column('status', '状态')->display(function ($status) {

            // 如果订单是付款, 那么就修改为物流状态
            if ($status == Order::STATUSES['ALI']) {

                return OrderTransform::getInstance()->transShipStatus($this->ship_status);
            }

            return OrderTransform::getInstance()->transStatus($status);
        });
        $grid->column('type', '订单类型')->display(function ($type) {

            return OrderTransform::getInstance()->transType($type);
        });
        $grid->column('pay_time', '支付时间');
        $grid->column('consignee_name', '收货人姓名');
        $grid->column('consignee_phone', '收货人手机');
        $grid->column('consignee_address', '收货地址');
        $grid->column('refund_reason', '退款理由');
        $grid->column('created_at', '创建时间');

        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->actions(function (Actions $actions) {

            /**
             * @var $order Order
             */
            $order = $actions->row;

            $url = admin_url("orders/{$order->id}/refund");

            // 如果出现了申请,显示可以退款按钮
            if ($order->status == Order::STATUSES['APP_REFUND']) {
                // append一个操作
                $actions->append("<a href='{$url}' title='退款'><i class='fa fa-mail-reply'></i></a>");
            } elseif ($order->isPay()) {

                if ($order->ship_status == Order::SHIP_STATUSES['PENDING']) {

                    $actions->append(new ShipButton($order->id));
                } elseif ($order->ship_status == Order::SHIP_STATUSES['DELIVERED']) {

                    $actions->append(new ReceivedButton($order->id));
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

        $show->field('total', '总计');
        $show->field('status', '状态')->as(function ($status) {

            // 如果订单是付款, 那么就修改为物流状态
            if ($status == Order::STATUSES['ALI']) {
                return OrderTransform::getInstance()->transShipStatus($this->ship_status);
            }

            return OrderTransform::getInstance()->transStatus($status);
        });
        $show->field('type', '订单类型')->as(function ($type) {

            return OrderTransform::getInstance()->transType($type);
        });

        $show->divider();

        $show->field('express_company', '物流公司');
        $show->field('express_no', '物流单号');

        $show->divider();

        $show->field('consignee_name', '收货人');
        $show->field('consignee_phone', '收货人手机');
        $show->field('consignee_address', '收货地址');

        $show->divider();

        $show->field('refund_reason', '退款理由');
        $show->field('pay_trade_no', '退款单号');
        $show->field('pay_no', '支付单号');
        $show->field('pay_time', '支付时间');
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '修改时间');

        // 详情
        $show->details('详情', function (Grid $details) {

            $details->column('id');
            $details->column('product.name', '商品名字');
            $details->column('price', '单价');
            $details->column('number', '数量');
            $details->column('is_commented', '是否评论')->display(function ($is) {

                return OrderDetailTransform::getInstance()->transCommented($is);
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



    /**
     * 这里为了执行退款，而直接点击退款。
     * 应该由会员申请退款，后台同意再调用
     * 第三方支付的退款接口
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refund(Order $order)
    {
        if ($order->user_id != auth()->id()) {
            abort(403, '非法操作');
        }

        // 订单必须在支付了，才可才可以退款
        if ($order->status != Order::STATUSES['APP_REFUND']) {
            abort(403, '订单当前状态禁止退款');
        }

        $pay = Pay::alipay(config('pay.ali'));

        // 退款数据
        $refundData = [
            'out_trade_no' => $order->no,
            'trade_no' => $order->pay_no,
            'refund_amount' => $order->pay_total,
            'refund_reason' => '正常退款',
        ];


        try {

            // 将订单状态改为退款
            $response = $pay->refund($refundData);
            $order->pay_refund_fee = $response->get('refund_fee');
            $order->pay_trade_no = $response->get('trade_no');
            $order->status = Order::STATUSES['REFUND'];
            $order->save();

        } catch (\Exception $e) {

            // 调用异常的处理
            // abort(500, $e->getMessage());
            return back()->withErrors('服务器异常，请稍后再试');
        }


        return redirect()->back()->with('status', '退款成功，请关注你的支付账号');
    }


    /**
     * 订单发货功能
     *
     * @param Request $request
     * @param Order   $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ship(Request $request, Order $order)
    {
        if (! $request->input('no')) {

            return back()->withErrors('物流编号不能为空', 'error');
        }

        if ($order->status != Order::SHIP_STATUSES['PENDING']) {

            return back()->withErrors('订单已经发货', 'error');
        }

        $order->ship_status = Order::SHIP_STATUSES['DELIVERED'];
        $order->express_company = $request->input('name');
        $order->express_no = $request->input('no');
        $order->save();

        admin_toastr('发货成功');

        return redirect()->back();
    }

    public function confirmShip(Order $order)
    {
        if (! $order->isPay()) {

            return back()->withErrors('订单未付款', 'error');
        }

        if ($order->ship_status != Order::SHIP_STATUSES['DELIVERED']) {

            return back()->withErrors('订单未发货', 'error');
        }

        $order->ship_status = Order::SHIP_STATUSES['RECEIVED'];
        $order->save();

        admin_toastr('收货成功');
        return redirect()->back();
    }
}
