<?php

namespace App\Enums;



class OrderShipStatusEnum extends Enum
{
    // 未发货
    const PENDING = 1;
    // 待收货
    const DELIVERED = 2;
    // 已收货
    const RECEIVED = 3;

}
