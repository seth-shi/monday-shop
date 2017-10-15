<?php

namespace App\Repositories;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function getUserByActiveToken($token)
    {
        return User::where('active_token', $token)->first();
    }

    public function getUserByNameAndPassword($username, $password)
    {
        // 获取字段类型
        $field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $user = User::where($field, $username)->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                return $user;
            }

            return false;
        }

        return false;
    }

    public function getUserById($id)
    {
        return User::find($id);
    }

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }


    public function getUserByName($username)
    {
        return User::where('name', $username)->first();
    }

    public function getUserByProviderId($field, $providerId)
    {
        $providers = [
            'github_id',
            'wechat_id',
            'weibo_id',
            'qq_id'
        ];

        if (! in_array($field, $providers)) {
            return false;
        }


        return User::where($field, $providerId)->first();
    }


}