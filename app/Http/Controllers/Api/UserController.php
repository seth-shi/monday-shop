<?php

namespace App\Http\Controllers\Api;

use App\Mail\UserRegister;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Mail;

class UserController extends ApiController
{
    public function sendActiveMail(Request $request)
    {
        // 查找到用户密码
        if ($user = $this->getUserByAccountAndPassword($request->input('account'), $request->input('password'))) {

            // 注册成功发送邮件加入队列
            Mail::to($user->email)
                ->queue(new UserRegister($user));

            return $this->setMsg('发送邮件成功')->toJson();

        }

        return $this->setCode(302)->setMsg('用户名或者密码错误')->toJson();
    }

    protected function getUserByAccountAndPassword($account, $password)
    {
        $filed = filter_var($account, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if ($user = User::where($filed, $account)->first()) {
            if (Hash::check($password, $user->password)) {
                return $user;
            }

            return false;
        }

        return false;
    }
}
