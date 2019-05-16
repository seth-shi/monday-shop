<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UserSexEnum;
use App\Enums\UserStatusEnum;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\OwnResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * 登录的接口
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::query()
                    ->whereNotNull('name')
                    ->where('name', $username)
                    ->first();

        if (is_null($user)) {
            return responseJsonAsBadRequest('用户名或者密码错误');
        }

        if (! Hash::check($password, $user->getAuthPassword())) {
            return responseJsonAsBadRequest('用户名或者密码错误');
        }


        return responseJson(200, '登录成功', $this->getToken($user));
    }

    /**
     * 注销的接口
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return responseJsonAsDeleted('注销成功');
    }

    /**
     * 注册的接口
     *
     * @param RegisterUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterUserRequest $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if (User::query()->where('name', $username)->exists()) {

            return responseJsonAsBadRequest('用户名已经存在, 请换一个用户名');
        }

        $user = new User();
        $user->name = $username;
        $user->password = $password;
        $user->sex = UserSexEnum::MAN;
        $user->is_init_email = 1;
        // api 注册的用户默认激活
        $user->is_active = UserStatusEnum::ACTIVE;
        $user->save();


        return responseJson(201, '注册成功', $this->getToken($user));
    }



    /**
     * 拼接 token
     *
     * @param User $user
     * @return array
     */
    protected function getToken(User $user)
    {
        // 换取 token
        $prefix = 'Bearer';
        $token = auth('api')->login($user);
        $me = new OwnResource($user);

        return compact('prefix', 'token', 'me');
    }
}
