<?php

namespace App\Admin\Actions\Post;

use App\Enums\OrderShipStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\User;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yansongda\Pay\Pay;

class OrderRefundAction extends RowAction
{
    public $name = '退款';


    public function handle(Order $order, Request $request)
    {
        // 订单必须申请支付了，才可才可以退款
        if ($order->status != OrderStatusEnum::APPLY_REFUND) {
            return $this->response()->error('订单当前状态禁止退款');
        }

        $pay = Pay::alipay(config('pay.ali'));

        // 退款数据
        $refundData = [
            'out_trade_no' => $order->no,
            'trade_no' => $order->pay_no,
            'refund_amount' => $order->pay_amount,
            'refund_reason' => '正常退款',
        ];

        try {

            // 将订单状态改为退款
            $response = $pay->refund($refundData);
            $order->pay_refund_fee = $response->get('refund_fee');
            $order->pay_trade_no = $response->get('trade_no');
            $order->status = OrderStatusEnum::REFUND;
            $order->save();

        } catch (\Exception $e) {

            // 调用异常的处理
            // abort(500, $e->getMessage());
            return $this->response()->error('服务器异常，请稍后再试');
        }

        return $this->response()->success('退款成功.')->refresh();
    }

    public function dialog()
    {
        $this->confirm('退款会直接把钱退回到支付账户，是否继续');
    }
}
