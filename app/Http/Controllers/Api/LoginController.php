<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\ErrorServe;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends ApiController
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        if (($validator = $this->validator($request->all()))->fails()) {
            return $this
                ->setCode(ErrorServe::HTTP_FORM_VALIDATOR_ERROR)
                ->setMsg($validator->errors()->first())
                ->toJson();
        }

        $credentials = $this->credentials($request);

        if ($user = $this->attemptLogin($credentials)) {


            $token = $user->createToken('monday')->accessToken;

            return $this->setMsg('登录成功')->setData(compact('token'))->toJson();
        }


        return $this->setMsg('账号或者密码错误')->setData($credentials)->toJson();
    }


    public function username()
    {
        return 'account';
    }

    private function validator(array $data)
    {
        return Validator::make($data, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ], [
            $this->username() . '.required' => '账号不能为空',
            $this->username() . '.string' => '账号必须是正确的字符串',
            'password.required' => '密码不能为空'
        ]);
    }

    protected function credentials(Request $request)
    {
        $field = filter_var($request->input($this->username()), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        return [
            $field => $request->input($this->username()),
            'password' => $request->input('password')
        ];
    }

    protected function attemptLogin(array $credentials)
    {
        if (empty($credentials)) {
            return false;
        }

        $query = new User();

        foreach ($credentials as $key => $value) {
            if (! Str::contains($key, 'password')) {
                $query = $query->where($key, $value);
            }
        }

        if (! $user = $query->first()) {
            return false;
        }

        return Hash::check($credentials['password'], $user->password) ? $user : false;
    }

    protected function guard()
    {
        return Auth::guard('api');
    }
}
