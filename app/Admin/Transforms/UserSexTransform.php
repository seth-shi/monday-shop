<?php

namespace App\Admin\Transforms;


use App\Enums\UserSexEnum;
use App\Enums\UserStatusEnum;
use App\Models\User;

class UserSexTransform implements Transform
{
    public static function trans($sex)
    {
        $text = '未知';

        if ($sex == UserSexEnum::MAN) {
            $text = '男';
        } elseif ($sex == UserSexEnum::WOMAN) {
            $text = '女';
        }

        return $text;
    }
}
