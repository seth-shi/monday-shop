<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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


    /**
     * 核心注册方法
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // 不要直接登录
        // $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * 注册之后的事件 （发送邮件）
     * @param Request $request
     * @param $user
     */
    protected function registered(Request $request, $user)
    {
        // 注册成功后发送邮件
        // TODO
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:50|unique:users',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ], [
            'name.unique' => '用户名已经被占用',
            'email.unique' => '邮箱已经被占用',
            'password.min' => '密码最少六位数',
            'password.confirmed' => '两次密码不一致'
        ]);
    }

    protected function create(array $data)
    {
        // 邮箱激活的 token, 用户头像
        return  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'active_token' => str_random(60),
            'avatar' => mt_rand(1, 9) . '.png'
        ]);

    }


}
