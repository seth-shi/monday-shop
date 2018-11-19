<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Overtrue\LaravelSocialite\Socialite;
use Overtrue\Socialite\AuthorizeFailedException;
use Overtrue\Socialite\SocialiteManager;
use Overtrue\Socialite\UserInterface;
use Faker\Factory;

class AuthLoginController extends Controller
{
    protected $allow = ['github', 'qq', 'weibo'];

    /**
     * 第三方授权登录跳转
     *
     * @param Request $request
     * @return mixed
     */
    public function redirectToAuth(Request $request)
    {
        $driver = $request->input('driver');

        if (! in_array($driver, $this->allow) || config()->has("socialite.{$driver}")) {

            abort(403, '未知的第三方登录');
        }

        $socialite = new SocialiteManager(config('socialite'));

        return $socialite->driver($driver)->redirect();
    }


    /**
     * 第三方授权认证回调
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function handleCallback(Request $request)
    {
        $driver = $request->input('driver');

        if (! in_array($driver, $this->allow) || config()->has("socialite.{$driver}")) {

            abort(403, '未知的第三方登录');
        }


        try {

            $socialite = new SocialiteManager(config('socialite'));
            $socialiteUser = $socialite->driver($driver)->user();
        } catch (AuthorizeFailedException $e) {

            return view('hint.error', ['status' => $e->getMessage(), 'url' => route('login')]);
        }

        // 处理第三方登录用户信息
        $user = $this->findOrCreateMatchUser($socialiteUser);


        Auth::login($user, true);

        // Do you need to jump to other places? gps:
        return redirect('/');
    }

    /**
     * 找到数据库匹配的记录，并存储用户
     *
     * @param \Overtrue\Socialite\User $socialiteUser
     * @return mixed
     */
    protected function findOrCreateMatchUser(\Overtrue\Socialite\User $socialiteUser)
    {
        $user = $this->getBindUser($socialiteUser);


        // 如果用户不存在，绑定邮箱
        if (! $user->exists) {

            if ($socialiteUser->getEmail()) {
                $user->email = $socialiteUser->getEmail();
            }

            if ($socialiteUser->getAvatar()) {
                $user->avatar = $socialiteUser->getAvatar();
            }
        }

        return tap($user, function (User $user) {

            // 使用第三方登录的用户，默认激活
            $user->is_active = 1;
            $user->save();
        });
    }

    /**
     * 找到第三方账号的用户
     *
     * @param \Overtrue\Socialite\User $socialiteUser
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    protected function getBindUser(\Overtrue\Socialite\User $socialiteUser)
    {
        // 新建用户
        $driver = strtolower($socialiteUser->getProviderName());
        $idField = "{$driver}_id";
        $nameField = "{$driver}_name";

        // 如果邮箱存在，直接绑定当前的这个用户
        $email = $socialiteUser->getEmail();
        if ($user = User::query()->where('email', $email)->first()) {
            $user->$idField = $socialiteUser->getId();
            $user->$nameField = $socialiteUser->getName();
            return $user;
        }

        $user = User::query()->firstOrNew([$idField => $socialiteUser->getId()]);
        $user->$nameField = $socialiteUser->getName();

        return $user;
    }
}
