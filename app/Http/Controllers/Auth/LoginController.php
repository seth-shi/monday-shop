<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $userRepository;

    /**
     * LoginController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('guest')->except('logout');

        // UserRepository
        $this->userRepository = $userRepository;
    }

    /**
     * 重写 login 方法
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response|void
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // 多次登录失败上锁
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // 试图登录
        if ($this->attemptLogin($request)) {

            // 获取当前登录用户
            $user = $this->guard()->user();

            // 如果用户没有激活
            if (! $this->userRepository->isActive($user))
            {
                // 退出登录
                Auth::logout();

                return back()->withInput()->withErrors([$this->username() => '账户未激活']);
            }

            return $this->sendLoginResponse($request);
        }

        // 如果登录尝试不成功，我们将增加次数
        // 登录并将用户重定向到登录表单。当然，当这
        // 用户超过他们的尝试，他们将被锁定的最大数量。
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * 登录之后（增加登录此时）
     * @param Request $request
     * @param $user
     */
    protected function authenticated(Request $request, $user)
    {
        //
        $user->increment('login_count');
    }


    /**
     * 登录前是否有跳转的 URL
     * @return string
     */
    public function redirectTo()
    {
        return request()->has('redirect_url') ? request()->input('redirect_url') : '/';
    }

    /**
     * 重写此方法，以达到可以用户名或者邮箱登录
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $field = filter_var($this->username(), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        return [
            $field => $request->input($this->username()),
            'password' => $request->input('password')
        ];
    }

    /**
     * 判断是用户名还是密码登录
     * @return string
     */
    public function username()
    {
        return 'account';
    }
}
