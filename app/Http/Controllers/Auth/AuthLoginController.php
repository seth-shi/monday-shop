<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserSourceEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Overtrue\Socialite\AuthorizeFailedException;
use Overtrue\Socialite\SocialiteManager;

class AuthLoginController extends Controller
{
    protected $allow = ['github', 'qq', 'weibo'];
    
    /**
     * 第三方授权登录跳转
     *
     * @param $driver
     * @return mixed
     */
    public function redirectToAuth($driver)
    {
        if (! in_array($driver, $this->allow) || ! config()->has("socialite.{$driver}")) {

            abort(403, '未知的第三方登录');
        }

        $socialite = new SocialiteManager(config('socialite'));

        return $socialite->driver($driver)->redirect();
    }
    
    
    /**
     * 第三方授权认证回调
     *
     * @param $driver
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function handleCallback($driver)
    {

        if (! in_array($driver, $this->allow) || ! config()->has("socialite.{$driver}")) {

            abort(403, '未知的第三方登录');
        }

        try {

            $socialite = new SocialiteManager(config('socialite'));
            $socialiteUser = $socialite->driver($driver)->user();
        } catch (AuthorizeFailedException $e) {

            return view('hint.error', ['status' => $e->getMessage(), 'url' => route('login')]);
        }

        /**
         * 处理第三方登录用户信息
         *
         * @var $user User
         */
        $user = $this->findOrCreateMatchUser($socialiteUser);

        // 如果用户已经登录的，作为绑定账号。跳转到个人中心页面
        if (auth()->check()) {

            return redirect('/user/setting')->with('status', '绑定成功');
        }

        // 第三方如果没有登录，那么主动登录
        auth()->login($user, true);
        // 登录次数
        $user->increment('login_count');

        // 如果 session 中有跳转 url，则跳转
        return redirect()->intended();
    }

    /**
     * 找到数据库匹配的记录，并存储用户
     *
     * @param \Overtrue\Socialite\User $socialiteUser
     * @return mixed
     */
    protected function findOrCreateMatchUser(\Overtrue\Socialite\User $socialiteUser)
    {
        // 新建用户
        $driver = strtoupper($socialiteUser->getProviderName());
        $idField = "{$driver}_id";
        $nameField = "{$driver}_name";

        /**
         * 如果是已经登录的用户
         * @var $user User
         */
        if ($user = auth()->user()) {
            $user->setAttribute($idField, $socialiteUser->getId())
                 ->setAttribute($nameField, $socialiteUser->getName())
                 ->save();

            return $user;
        }

        // 如果用户没有登录，就是使用第三方账号登录
        // 如果数据库没有记录就创建，有就修改一下显示名
        $user = User::query()->firstOrNew([$idField => $socialiteUser->getId()]);
        $user->$nameField = $socialiteUser->getName();
        // 用户的来源
        $sources = UserSourceEnum::toArray();
        $user->source = $sources[$driver] ?? array_first($sources);

        // 如果用户不存在
        if (! $user->exists) {

            if ($socialiteUser->getAvatar()) {
                $user->avatar = $socialiteUser->getAvatar();
            }

            // 用户的密码是初始的，可以不用输入旧密码修
            //// 使用第三方登录的用户，默认激活
            $user->is_active = 1;
            $user->is_init_name = 1;
            $user->is_init_email = 1;
            $user->is_init_password = 1;
        }

        $user->save();

        return $user;
    }
    
    
    /**
     * 解绑第三方账号
     *
     * @param $driver
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unBind($driver, Request $request)
    {
        if (! in_array($driver, $this->allow) || ! config()->has("socialite.{$driver}")) {

            return back()->withErrors(['msg' => '未知的第三方登录']);
        }


        // 可以做更多的判断，如用 QQ 注册的不能解绑之类的
        /**
         * @var $user User
         */
        $idField = "{$driver}_id";
        $nameField = "{$driver}_name";
        $user = $request->user();
        $user->setAttribute($idField, null)->setAttribute($nameField, null)->save();


        return back()->with('status', '解绑成功');
    }
}
