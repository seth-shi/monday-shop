<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserRegister;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function activeAccount($token)
    {
        if ($user = User::query()->where('active_token', $token)->first()) {
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
        if ($user = User::query()->find($id)) {
            //  again send active link, join queue
            Mail::to($user->email)
                ->queue(new UserRegister($user));

            return view('hint.success', ['status' => '发送邮件成功', 'url' => route('login')]);

        }

        return view('hint.error', ['status' => '用户名或者密码错误']);
    }
}
