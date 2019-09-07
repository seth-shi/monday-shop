<?php

namespace App\Enums;


use MyCLabs\Enum\Enum;

class HomeCacheEnum extends Enum
{
    const CATEGORIES = 'home:categories';
    const HOTTEST = 'home:hottest';
    const LATEST = 'home:latest';
    const USERS = 'home:users';
    const COUPON_TEMPLATES = 'home:templates';
}
