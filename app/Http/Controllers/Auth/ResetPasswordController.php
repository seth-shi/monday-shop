<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    /**
     * rewrite Illuminate\Foundation\Auth\ResetsPasswords::resetPassword not login
     * @param $user
     * @param $password
     */
    public function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        // event(new PasswordReset($user));
        // $this->guard()->login($user);
    }

    public function redirectTo()
    {
        return 'password/reset';
    }
}
