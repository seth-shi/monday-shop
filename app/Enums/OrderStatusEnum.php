<?php

namespace App\Enums;


use MyCLabs\Enum\Enum;

class OrderStatusEnum extends Enum
{

    const UN_PAY_CANCEL = 0;
    // 未支付
    const UN_PAY = 1;
    // 已经支付
    const PAID = 2;
    // 订单完成
    const COMPLETED = 3;

    // 超时未支付
    const TIMEOUT_CANCEL = 4;
    // 申请退款
    const APPLY_REFUND = 5;
    // 退款
    const REFUND = 6;

}
