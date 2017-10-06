<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoginPost;
use App\Repositories\UserRepository;

class LoginController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function create()
    {
        return view('auth.login');
    }


    public function store(StoreLoginPost $request)
    {
        $user = $this->userRepository->login($request->input('account'), $request->input('password'));

        // 登录成功
        if ($user) {

            if (! $this->userRepository->isActive($user))
            {
                // 跳回登录页面提示错误信息
                return back()->withInput()->with('account', '账号未激活');
            }

            session(['user' => $user->username]);

            // 判断是否有回调 URL
            $route = $request->input('redirect_url') ?? '/';

            return redirect($route);

        } else {

            // 跳回登录页面提示错误信息
            return back()->withInput()->withErrors(['account' => '账号或者密码错误']);
        }
    }

}
