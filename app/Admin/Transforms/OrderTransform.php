<?php

namespace App\Admin\Transforms;


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

    public function transStatus($status)
    {
        switch ($status) {

            case Order::PAY_STATUSES['REFUND']:
                $text = '退款';
                break;
            case Order::PAY_STATUSES['UN_PAY']:
                $text = '未支付';
                break;
            case Order::PAY_STATUSES['ALI']:
                $text = '阿里支付';
                break;
            case Order::PAY_STATUSES['WEIXIN']:
                $text = '微信支付';
                break;
            default:
                $text = '未知状态';
                break;
        }

        return $text;
    }
}
