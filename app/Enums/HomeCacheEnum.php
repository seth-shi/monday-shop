<?php

namespace App\Enums;


use MyCLabs\Enum\Enum;

class HomeCacheEnum extends Enum
{
    // CHANGE: 修改 kye 名,防止旧版本 key 永久缓存不修改
    const SEC_KILL_DATA = 'home_page:sec_kill_data';
    const CATEGORIES = 'home_page:categories';
    const HOTTEST = 'home_page:hottest';
    const LATEST = 'home_page:latest';
    const USERS = 'home_page:users';
    const COUPON_TEMPLATES = 'home_page:templates';
}
