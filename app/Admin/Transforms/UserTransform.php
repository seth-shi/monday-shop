<?php

namespace App\Admin\Transforms;


use App\Enums\UserSexEnum;
use App\Enums\UserStatusEnum;
use App\Models\User;

class UserTransform extends Transform
{
    public function transStatus($isAlive)
    {
        return $isAlive == UserStatusEnum::ACTIVE
            ? "<span class='label' style='color: green;'>激活</span>"
            : "<span class='label' style='color: red;'>未激活</span>";
    }

    public function transSex($sex)
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
