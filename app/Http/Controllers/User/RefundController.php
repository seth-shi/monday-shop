<?php

namespace App\Http\Controllers\User;

use App\Enums\OrderShipStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Yansongda\Pay\Pay;

class RefundController extends Controller
{
    /**
     * @param Request $request
     * @param Order   $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Order $order)
    {
        if ($order->isNotUser(auth()->id())) {

            return responseJson(403, '不是自己的订单');
        }

        // 订单必须是已经支付,而且还没有发货的
        if ($order->status != OrderStatusEnum::PAID) {

            return responseJson(403, '订单还没有付款');
        }

        if ($order->ship_status != OrderShipStatusEnum::PENDING) {

            return responseJson(403, '订单已经发货');
        }

        // 保存退款理由
        $order->status = OrderStatusEnum::APPLY_REFUND;
        $order->refund_reason = $request->input('refund_reason');
        $order->save();

        return responseJson(200, '申请已提交,等待后台管理员审核');
    }
}
