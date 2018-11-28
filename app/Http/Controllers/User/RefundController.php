<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Yansongda\Pay\Pay;

class RefundController extends Controller
{
    public function store(Order $order)
    {
        if ($order->user_id != auth()->id()) {
            abort(403, '非法操作');
        }

        // TODO 支付回调，退款,沙箱暂时用不了，等以后进行
        $pay = Pay::alipay(config('pay.ali'));

        $refundData = [
            'out_trade_no' => $order->no,
            'refund_amount' => $order->pay_total,
            'refund_reason' => '正常退款',
        ];

        $response = $pay->refund($refundData);
        try {

        } catch (\Exception $e) {

            // 调用异常的处理

        }

        // 将订单状态改为退款

        dd($response);
    }
}
