<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::query()
                    ->whereNotNull('name')
                    ->where('name', $request->input('username'))
                    ->first();

        if (is_null($user)) {
            return responseJsonAsBadRequest('用户名或者密码错误');
        }

        if (! Hash::check($request->input('password'), $user->getAuthPassword())) {
            return responseJsonAsBadRequest('用户名或者密码错误');
        }

        // 换取 token
        $prefix = 'Bearer';
        $token = auth('api')->login($user);

        return responseJson(200, '登录成功', compact('prefix', 'token'));
    }
}
