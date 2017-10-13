<?php

namespace App\Http\Controllers\Api;

use App\Mail\UserRegister;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class UserController extends ApiController
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function sendActiveMail(Request $request)
    {
        $account = $request->input('account');
        $password = $request->input('password');

        // 查找到用户密码
        $user = $this->userRepository->getUserByNameAndPassword($account, $password);

        if (! $user) {
            return $this->setErrno(302)->setMsg('用户名或者密码错误')->response();
        }

        // 注册成功发送邮件加入队列
        Mail::to($user->email)
            ->queue(new UserRegister($user));

        return $this->setMsg('发送邮件成功')->response();
    }
}
