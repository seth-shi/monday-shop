<?php

namespace App\Repositories;


use App\Models\User;

class UserRepository
{
    public function isActive(User $user)
    {

    }

    public function getUser($name, $password)
    {
        User::where(['name' => $name, 'password' => $password])->first();
    }
}