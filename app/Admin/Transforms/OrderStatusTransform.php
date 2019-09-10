<?php

namespace App\Admin\Transforms;


use App\Enums\OrderShipStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\OrderTypeEnum;
use App\Models\Order;

class OrderStatusTransform implements Transform
{
    public static function trans($status)
    {
        switch ($status) {

            case OrderStatusEnum::UN_PAY_CANCEL:
                $text = '取消';
                break;
            case OrderStatusEnum::REFUND:
                $text = '退款';
                break;
            case OrderStatusEnum::APPLY_REFUND:
                $text = '申请退款';
                break;
            case OrderStatusEnum::UN_PAY:
                $text = '未支付';
                break;
            case OrderStatusEnum::PAID:
                $text = '已支付';
                break;
            case OrderStatusEnum::TIMEOUT_CANCEL:
                $text = '超时未付款系统自动取消';
                break;
            case OrderStatusEnum::COMPLETED:
                $text = '完成';
                break;
            default:
                $text = '未知状态';
                break;
        }

        return $text;
    }
}
