<?php

namespace App\Enums;


use MyCLabs\Enum\Enum;

class UserSourceEnum extends Enum
{
    // 默认上城创建
    const MOON = 1;
    const GITHUB = 2;
    const QQ = 3;
    const WEIBO = 4;
}
