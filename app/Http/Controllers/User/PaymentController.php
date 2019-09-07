<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Jenssegers\Agent\Agent;
use Yansongda\Pay\Pay;

class PaymentController extends Controller
{

    /**
     * 再次支付的接口
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function againStore($id)
    {
        /**
         * @var $masterOrder Order
         */
        $masterOrder = Order::query()->findOrFail($id);

        // 生成支付信息
        return $this->buildPayForm($masterOrder, (new Agent)->isMobile());
    }

    /**
     * 生成支付订单
     *
     * @param Order $order
     * @param       $isMobile
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function buildPayForm(Order $order, $isMobile)
    {
        // 创建订单
        $order = [
            'out_trade_no' => $order->no,
            'total_amount' => $order->amount,
            'subject' => $order->name,
        ];

        $pay = Pay::alipay(config('pay.ali'));

        if ($isMobile) {

            return $pay->wap($order);
        }

        return $pay->web($order);
    }
}
