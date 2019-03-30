<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserSexEnum;
use App\Http\Controllers\Controller;
use App\Mail\UserRegister;
use App\Models\User;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        if ($request->input('captcha') != session()->get('captcha')) {

            return back()->withErrors(['captcha' => '验证码不正确']);
        }


        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath())->with('status', '注册成功');
    }

    /**
     * registered event (send email)
     * @param Request $request
     * @param $user
     */
    protected function registered(Request $request, $user)
    {
        Mail::to($user->email)
            ->queue(new UserRegister($user));
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:50|unique:users',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:5|confirmed',
            'sex' => ['required', Rule::in([UserSexEnum::MAN, UserSexEnum::WOMAN])],
            'captcha' => 'required',
        ], [
            'name.required' => '用户名不能为空',
            'name.max' => '用户名不能超过50个字符',
            'name.unique' => '用户名已经被占用',
            'email.unique' => '邮箱已经被占用',
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
            'password.min' => '密码最少六位数',
            'password.required' => '密码不能为空',
            'password.confirmed' => '两次密码不一致',
            'captcha.required' => '验证码不能为空',
            'sex.in' => '性别错误',
        ]);
    }

    protected function create(array $data)
    {
        // email_active,
        return  User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'sex' => $data['sex'],
            'password' => bcrypt($data['password']),
            'active_token' => str_random(60),
        ]);

    }

    protected function redirectTo()
    {
        return 'register';
    }


    /**
     * @return string
     */
    public function captcha()
    {
        $builder = (new CaptchaBuilder(4))->build(150, 46);

        session()->put('captcha', $builder->getPhrase());

        return $builder->get();
    }
}
