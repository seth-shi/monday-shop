<?php

namespace App\Admin\Transforms;


use App\Enums\OrderShipStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\OrderTypeEnum;
use App\Models\Order;

class OrderShipStatusTransform implements Transform
{
    public static function trans($status)
    {
        switch ($status) {

            case OrderShipStatusEnum::PENDING:
                $text = '未发货';
                break;
            case OrderShipStatusEnum::DELIVERED:
                $text = '待收货';
                break;
            case OrderShipStatusEnum::RECEIVED:
                $text = '已收货';
                break;
            default:
                $text = '未知状态';
                break;
        }

        return $text;
    }
}
