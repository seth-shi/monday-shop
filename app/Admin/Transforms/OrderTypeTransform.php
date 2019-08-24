<?php

namespace App\Admin\Transforms;


use App\Enums\OrderShipStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\OrderTypeEnum;
use App\Models\Order;

class OrderTypeTransform implements Transform
{
    public static function trans($type)
    {
        $text = '未知';

        if ($type == OrderTypeEnum::COMMON) {
            $text = '普通订单';
        } elseif ($type == OrderTypeEnum::SEC_KILL) {
            $text = '秒杀订单';
        }

        return $text;
    }
}
