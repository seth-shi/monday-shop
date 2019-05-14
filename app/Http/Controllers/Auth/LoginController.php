<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ScoreLogServe;
use App\Services\UserService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use RedirectsUsers, ThrottlesLogins;

    protected $redirectTo = '/';

    // 排除记录的回跳 url, 防止重复跳转
    protected $except = ['*login*', '*register*'];


    /**
     * LoginController constructor.
     */
    public function __construct()
    {
       $this->middleware('guest')->except('logout');
    }


    /**
     * 登录页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        $lastUrl = URL::previous();


        // 记录上一次的 url，用于登录之后的回跳
        if (! str_is($this->except, $lastUrl)) {

            session()->put('url.intended', $lastUrl);
        }

        return view('auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request, UserService $userService)
    {
        $this->validateLogin($request);

        // 如果超过限制登录次数
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

           $this->sendLockoutResponse($request);
        }

        /**
         * @var $user User
         */
        $credentials = $this->credentials($request);
        $user = User::query()->where($credentials)->first();

        if ($user instanceof User  && \Hash::check($request->input('password'), $user->password)) {

            // 如果用户没有激活
            if ($user->is_active == UserStatusEnum::UN_ACTIVE) {

                // 显示 再次发送激活链接
                return redirect('login')->withInput()
                                        ->withErrors([
                                            $this->username() => $userService->getActiveLink($user)
                                        ]);
            }

            // 登录用户
            auth()->login($user, $request->has('remember'));

            return $this->sendLoginResponse($request);
        }

        // 如果登录尝试不成功，我们将增加数量
        // 登录并将用户重定向到登录表单。当然，当这个
        // 超过最大尝试次数的用户将被锁定。
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * 登录之后增加登录次数
     *
     * @param $user
     */
    protected function authenticated($user)
    {
        $user->increment('login_count');
    }


    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request->user())
            ?: redirect()->intended($this->redirectPath());
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * 登录使用用户名还是邮箱
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $input = $request->input($this->username());
        $field = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        return [
            $field => $input,
        ];
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ], [
            $this->username() . '.required' => '账号不能为空',
            $this->username() . '.string' => '账号必须是正确的字符串',
            'password.required' => '密码不能为空'
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    protected function username()
    {
        return 'account';
    }
}
