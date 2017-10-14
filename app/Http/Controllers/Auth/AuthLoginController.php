<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    public function handleProviderCallback()
    {
        $socialite = Socialite::driver('github')->user();

        if (! $socialite) {

            return view('hint.error', ['msg' => '第三方登录出错']);
        }

        // 获取第三方服务
        $provider_name = strtolower($socialite->getProviderName());
        $provider = $this->formatProvider($provider_name);


        // 先去查询数据库是否有用户， 如果已经存在就登录， 不存在就创建
        if (! $user = $this->userRepository->getUserByProviderId($provider['id'], $socialite['id'])) {
            $user = $this->createUserByProvider($socialite, $provider_name);
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

        // 如 github => ['id']
        return [
            'id' => $provider . '_id',
            'name' => $provider . '_name'
        ];
    }

    /**
     * 通过第三方服务登录创建用户
     * @param UserInterface $provider
     * @return User
     */
    public function createUserByProvider(UserInterface $provider, $providerType)
    {

        if (! in_array($providerType, $this->providerType)) {
            throw new Exception('不允许的第三方服务');
        }

        // 拼接成对应数据库的字段如github登录则是  github_id,  github_name
        $provider_id = $providerType . '_id';
        $provider_name = $providerType . '_name';


        // 如果此邮件已经存在，则就直接绑定账户，方便下次登录
        $user = $this->userRepository->getUserByEmail($provider['email']);

        if ($user) {
            // 绑定账号
            $user->$provider_id = $provider['id'];
            $user->$provider_name = $provider['nickname'];
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

            $user->github_id = $provider['id'];
            $user->email = $provider['email'];
            $user->github_name = $provider['nickname'];
            $user->password = bcrypt('123456');
            $user->active_token = str_random(60);
        }
        $user->save();

        return $user;
    }

}
