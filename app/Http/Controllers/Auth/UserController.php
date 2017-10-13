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

            return view('hint.success', ['msg' => "{$user->name} 账户激活成功！", 'url' => url('login')]);
        } else {
            return view('hint.error', ['msg' => '无效的token']);
        }
    }
}
