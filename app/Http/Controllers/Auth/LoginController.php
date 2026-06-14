<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    private const MAX_ATTEMPTS = 5;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $lastUrl = URL::previous();
        if (! Str::is(['*login*', '*register*'], $lastUrl)) {
            session()->put('url.intended', $lastUrl);
        }

        return view('auth.login');
    }

    public function login(Request $request, UserService $userService)
    {
        $credentials = $request->validate([
            'account' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = Str::transliterate(Str::lower($credentials['account']).'|'.$request->ip());
        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            throw ValidationException::withMessages([
                'account' => ['登录尝试过多，请在 '.RateLimiter::availableIn($throttleKey).' 秒后重试。'],
            ]);
        }

        $field = filter_var($credentials['account'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $user = User::query()->where($field, $credentials['account'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            RateLimiter::hit($throttleKey, 60);
            throw ValidationException::withMessages(['account' => [trans('auth.failed')]]);
        }

        if ((int) $user->is_active === UserStatusEnum::UN_ACTIVE) {
            return back()->withInput($request->only('account'))->withErrors([
                'account' => $userService->getActiveLink($user),
            ]);
        }

        auth()->login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        RateLimiter::clear($throttleKey);
        $user->increment('login_count');

        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
