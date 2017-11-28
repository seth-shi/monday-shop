<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Overtrue\LaravelSocialite\Socialite;
use Overtrue\Socialite\AuthorizeFailedException;
use Overtrue\Socialite\UserInterface;
use Faker\Factory;

class AuthLoginController extends Controller
{
    /**
     * Third party GitHub authorization
     * @return mixed
     */
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * handle authorization callback
     * @return mixed
     */
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
        try {
            $socialite = Socialite::driver('weibo')->user();
        } catch (AuthorizeFailedException $e) {
            return view('hint.error', ['status' => $e->getMessage(), 'url' => route('login')]);
        }


        return $this->handleProviderCallback($socialite);
    }

    /**
     * Processing third party login callback
     * @param $socialite
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     *     |\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    private function handleProviderCallback($socialite)
    {
        if (!$socialite) {

            return view('hint.error', ['status' => '第三方登录出错']);
        }

        // Access to third party services
        list($providerId, $providerName) = $providerType = $this->formatProvider($socialite['provider']);

        // First query the database whether there is a user, if it already exists, log on
        if (!$user = User::where($providerId, $socialite['id'])->first()) {

            $user = $this->createUserByProvider($socialite, $providerType);
        }

        Auth::login($user, true);

        // Do you need to jump to other places? gps:
        return redirect('/');
    }

    /**
     * Fields converted into third party services in a database
     * @param $provider
     * @return array
     */
    public function formatProvider($provider)
    {
        $provider = strtolower($provider);

        // for instance: github => ['github_id', 'github_name']
        return [
            $provider . '_id',
            $provider . '_name'
        ];
    }

    /**
     * Create user through third party service login
     * @param UserInterface $provider
     * @return User
     */
    public function createUserByProvider(UserInterface $provider, array $providerType)
    {
        list($providerId, $providerName) = $providerType;

        // by email find user Is there
        if ($user = User::where('email', $provider['email'])->first()) {
            // if user already exists, bind the account only
            $user->$providerId = $provider['id'];
            $user->$providerName = $provider['nickname'];
            $user->save();

        } else {
            $data = $this->getFormatFiledData($provider, $providerId, $providerName);
            $user = User::create($data);
        }

        return $user;
    }

    /**
     * Formats the data returned by the third party into a database field
     * $providerId possible is github_id || qq_id ...
     * @param $provider
     * @param $providerId
     * @param $providerName
     * @return array
     */
    public function getFormatFiledData($provider, $providerId, $providerName)
    {
        // 数据库填充对象
        $faker = Factory::create();

        $data = [
            'name' => $faker->uuid,
            'avatar' => $faker->imageUrl(120, 120),
            'email' => $faker->email
        ];



        if (! User::where('name', $provider['nickname'])->first()) {
            $data['name'] = $provider['nickname'];
        }

        if (isset($provider['avatar'])) {
            $data['avatar'] = $provider['avatar'];
        }

        if (isset($provider['email']) && $provider['email']) {
            $data['email'] = $provider['email'];
        }

        if (isset($provider['sex'])) {
            $data['sex'] = $provider['sex'];
        }

        $data[$providerId] = $provider['id'];
        $data[$providerName] = $provider['nickname'];
        $data['password'] = bcrypt('123456');
        $data['active_token'] = str_random(60);
        // Default activation by using third party login
        $data['is_active'] = 1;

        return $data;
    }

}
