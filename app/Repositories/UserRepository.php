<?php

namespace App\Repositories;


use App\Models\User;

class UserRepository
{

    /**
     * 用户登录
     * @param $account
     * @param $password
     * @return mixed
     */
    public function login($account, $password)
    {
        // 判断账户使用邮箱登录还是用户名登录
        $filed = filter_var($account, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return User::where([$filed => $account, 'password' => md5($password)])->first();
    }


    public function register()
    {

    }

    /**
     * 通过用户名或者邮箱获取用户信息
     * @param $account
     * @return mixed
     */
    public function getUserByAccount($account)
    {
        // 判断账户使用邮箱登录还是用户名登录
        $filed = filter_var($account, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return User::where($filed, $account)->first();
    }

    public function getUserById($id)
    {
        return User::find($id);
    }

    public function getUsers($limit = 5)
    {
        return User::orderBy('created_at', 'desc')->limit($limit)->get();
    }

    /**
     * 账号是否激活
     * @param $user
     * @return bool
     */
    public function isActive(User $user)
    {
        return $user->status != 0;
    }
}