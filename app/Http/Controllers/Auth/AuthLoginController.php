<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Overtrue\LaravelSocialite\Socialite;
use Overtrue\Socialite\UserInterface;


class AuthLoginController extends Controller
{
    protected $providerType = [
        'github',
        'wechat',
        'weibo',
        'qq'
    ];

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        $socialite = Socialite::driver('github')->user();

        return $this->handleProviderCallback($socialite);
    }


    public function redirectToQQ()
    {
        return Socialite::driver('qq')->redirect();
    }

    public function handleQQCallback()
    {
        $socialite = Socialite::driver('qq')->user();

        return $this->handleProviderCallback($socialite);
    }


    public function redirectToWeibo()
    {
        return Socialite::driver('weibo')->redirect();
    }

    public function handleWeiboCallback()
    {
        $socialite = Socialite::driver('weibo')->user();

        return $this->handleProviderCallback($socialite);
    }

    private function handleProviderCallback($socialite)
    {
        if (! $socialite) {

            return view('hint.error', ['msg' => '第三方登录出错']);
        }

        // 获取第三方服务
        $providerType = $this->formatProvider($socialite['provider']);

        // 先去查询数据库是否有用户， 如果已经存在就登录， 不存在就创建, 传入 第三方的 ID
        if (! $user = $this->userRepository->getUserByProviderId($providerType[0], $socialite['id'])) {

            $user = $this->createUserByProvider($socialite, $providerType);
        }

        // 登录用户
        Auth::login($user, true);

        return redirect('/');
    }

    /**
     * 转换成数据库的字段
     * @param $provider
     * @return array
     */
    public function formatProvider($provider)
    {
        $provider = strtolower($provider);

        // 如 github => ['github_id', 'github_name']
        return [
            $provider . '_id',
            $provider . '_name'
        ];
    }

    /**
     * 通过第三方服务登录创建用户
     * @param UserInterface $provider
     * @return User
     */
    public function createUserByProvider(UserInterface $provider, array $providerType)
    {
        list($providerId, $providerName) = $providerType;

        // 如果此邮件已经存在，则就直接绑定账户，方便下次登录
        $user = $this->userRepository->getUserByEmail($provider['email']);

        if ($user) {
            // 绑定账号
            $user->$providerId = $provider['id'];
            $user->$providerName = $provider['nickname'];
        } else {

            $user = new User();

            // 用户名已经存在 则跳转到注册页面
            if ($this->userRepository->getUserByName($provider['nickname'])) {
                $user->name = str_random(5);
            } else {
                $user->name = $provider['nickname'];
            }

            if (isset($provider['avatar'])) {
                $user->avatar = $provider['avatar'];
            } else {
                $user->avatar = mt_rand(1, 9) . '.png';
            }

            if (is_null($provider['email'])) {
                $user->email = '0';
            } else {
                $user->email = $provider['email'];
            }

            $user->$providerId = $provider['id'];
            $user->$providerName = $provider['nickname'];
            $user->password = bcrypt('123456');
            $user->active_token = str_random(60);
        }
        $user->save();

        return $user;
    }

}
