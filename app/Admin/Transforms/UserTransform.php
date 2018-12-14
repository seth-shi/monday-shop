<?php

namespace App\Admin\Transforms;


use App\Models\User;

class UserTransform extends Transform
{
    public function transStatus($isAlive)
    {
        return $isAlive == User::ACTIVE_STATUS
            ? "<span class='label' style='color: green;'>激活</span>"
            : "<span class='label' style='color: red;'>未激活</span>";
    }
}
