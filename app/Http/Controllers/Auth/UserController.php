<?php

namespace App\Http\Controllers\Auth;

use App\Mail\UserRegister;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function activeAccount($token)
    {
        $user = $this->userRepository->getUserByActiveToken($token);

        if ($user) {
            $user->is_active = 1;
            // 重新生成激活token
            $user->active_token = str_random(60);
            $user->save();

            return view('hint.success', ['status' => "{$user->name} 账户激活成功！", 'url' => url('login')]);
        } else {
            return view('hint.error', ['status' => '无效的token']);
        }
    }

    public function sendActiveMail($id)
    {
        // 查找到用户密码
        $user = $this->userRepository->getUserById($id);

        if (! $user) {

            return view('hint.error', ['status' => '用户名或者密码错误']);
        }

        // 注册成功发送邮件加入队列
        Mail::to($user->email)
            ->queue(new UserRegister($user));

        return view('hint.success', ['status' => '发送邮件成功', 'url' => route('login')]);
    }
}
