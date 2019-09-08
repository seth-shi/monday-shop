<?php

namespace App\Enums;


use MyCLabs\Enum\Enum;

class SettingKeyEnum extends Enum
{
    const USER_INIT_PASSWORD = 'user_init_password';
    const IS_OPEN_SECKILL = 'is_open_seckill';
    const UN_PAY_CANCEL_TIME = 'order_un_pay_auto_cancel_time';
    const POST_AMOUNT = 'post_amount';
}
