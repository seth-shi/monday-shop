<?php

namespace App\Repositories;


use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminRepository
{

    public function getUserByNameAndPassword($account, $password)
    {
        $field = filter_var($account, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $user = Admin::where($field, $account)->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                return $user;
            }

            return false;
        }

        return false;
    }


}