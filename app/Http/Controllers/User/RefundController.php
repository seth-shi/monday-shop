<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Yansongda\Pay\Pay;

class RefundController extends Controller
{
    /**
     * 这里为了执行退款，而直接点击退款。
     * 应该由会员申请退款，后台同意再调用
     * 第三方支付的退款接口
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Order $order)
    {
        $this->validateOrderInvalid($order);

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
            $order->status = Order::PAY_STATUSES['REFUND'];
            $order->save();

        } catch (\Exception $e) {

            // 调用异常的处理
            abort(500, $e->getMessage());
        }


        return redirect()->back()->with('status', '退款成功，请关注你的支付账号');
    }

    protected function validateOrderInvalid(Order $order)
    {
        if ($order->user_id != auth()->id()) {
            abort(403, '非法操作');
        }

        // 订单必须在支付了，才可才可以退款
        if ($order->status != Order::PAY_STATUSES['ALI']) {
            abort(403, '订单当前状态禁止退款');
        }
    }
}
