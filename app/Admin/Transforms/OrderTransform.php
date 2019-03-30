<?php

namespace App\Admin\Transforms;


use App\Enums\OrderStatusEnum;
use App\Models\Order;

class OrderTransform extends Transform
{

    public function transDeleted($isDeleted)
    {
        return $isDeleted ? '<span class="glyphicon glyphicon-ok bg-green"></span>' : '';
    }

    public function transCommented($isCommented)
    {
        return $isCommented ? '<span class="glyphicon glyphicon-ok bg-green"></span>' : '';
    }


    public function transType($type)
    {
        $text = '未知';

        if ($type == 1) {
            $text = '普通订单';
        } elseif ($type == 2) {
            $text = '秒杀订单';
        }

        return $text;
    }

    public function transShipStatus($status)
    {
        switch ($status) {

            case Order::SHIP_STATUSES['PENDING']:
                $text = '待发货';
                break;
            case Order::SHIP_STATUSES['DELIVERED']:
                $text = '待收货';
                break;
            case Order::SHIP_STATUSES['RECEIVED']:
                $text = '已收货';
                break;
            default:
                $text = '未知状态';
                break;
        }

        return $text;
    }

    public function transStatus($status)
    {
        switch ($status) {

            case OrderStatusEnum::REFUND:
                $text = '退款';
                break;
            case OrderStatusEnum::APP_REFUND:
                $text = '申请退款';
                break;
            case OrderStatusEnum::UN_PAY:
                $text = '未支付';
                break;
            case OrderStatusEnum::PAID:
                $text = '已支付';
                break;
            case OrderStatusEnum::UN_PAY_CANCEL:
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
