<?php

namespace App\Repositories;


use App\Models\User;

class UserRepository
{
    /**
     * 判断用户是否验证
     * @param User $user
     * @return bool
     */
    public function isActive(User $user)
    {
        return $user->is_active == 1;
    }


}