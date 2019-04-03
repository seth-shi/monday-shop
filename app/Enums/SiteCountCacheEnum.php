<?php

namespace App\Enums;


use MyCLabs\Enum\Enum;

class SiteCountCacheEnum extends Enum
{
    // 注册的 key
    const REGISTERED_COUNT = 'site_counts:registered_count';
    const GITHUB_REGISTERED_COUNT = 'site_counts:github_registered_count';
    const QQ_REGISTER_COUNT = 'site_counts:qq_registered_count';
    const WEIBO_REGISTER_COUNT = 'site_counts:weibo_registered_count';
    const MOON_REGISTER_COUNT = 'site_counts:moon_registered_count';

    // 订单的 key 统计
    const ORDER_COUNT = 'site_counts:order_count';
    // 成功支付的订单
    const PAY_ORDER_COUNT = 'site_counts:order_pay_count';
    // 退款订单量
    const REFUND_ORDER_COUNT = 'site_counts:refund_pay_count';
    // 销售金额
    const SALE_ORDER_COUNT = 'site_counts:sale_money_count';
}
