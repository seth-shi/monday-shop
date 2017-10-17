<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function validationErrorMessages()
    {
        return [
            'token.required' => '重置密码的token不是对应这个邮箱',
            'email.required' => '邮件地址不正确',
            'email.email' => '邮件地址不正确',
            'password.required' => '密码不能为空',
            'password.confirmed' => '两次密码不一致',
            'password.min' => '密码不能少于六位数',
        ];
    }
}
