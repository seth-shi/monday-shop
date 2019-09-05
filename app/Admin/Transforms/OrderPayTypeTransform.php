<?php

namespace App\Admin\Transforms;


use App\Enums\OrderPayTypeEnum;
use App\Enums\OrderShipStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\OrderTypeEnum;
use App\Models\Order;

class OrderPayTypeTransform implements Transform
{
    public static function trans($type)
    {
        $text = '';

        if ($type == OrderPayTypeEnum::ALI) {
            $text = '支付宝';
        } elseif ($type == OrderPayTypeEnum::WECHAT) {
            $text = '微信';
        }

        return $text;
    }
}
