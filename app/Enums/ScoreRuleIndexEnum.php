<?php

namespace App\Enums;


use MyCLabs\Enum\Enum;

class ScoreRuleIndexEnum extends Enum
{
    const CONTINUE_LOGIN = 'continue_login';
    const VISITED_PRODUCT = 'visited_product';
    const COMPLETE_ORDER = 'complete_order';
    const LOGIN = 'login';
    const REGISTER = 'register';
}
