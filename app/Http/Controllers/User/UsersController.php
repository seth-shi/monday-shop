<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{

    public function index()
    {
        $user = $this->guard()->user();
        $hotProduct = Product::where('safe_count', 'desc')->first();


        return view('user.homes.index', compact('user', 'hotProduct'));
    }



    public function setting()
    {
        $user = Auth::user();

        return view('user.users.setting', compact('user'));
    }



    public function update(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required',
            'sex' => 'in:0,1',
            'name' => 'required:unique:users'
        ], [
           'avatar.required' => '头像不能为空',
           'sex.in' => '性别格式不对',
           'name.required' => '用户名不能为空',
           'name.unique' => '用户名已经存在',
        ]);


        $this->guard()->user()->update($request->only(['avatar', 'name', 'sex']));

        return back()->with('status', '修改成功');
    }


    public function subscribe(Request $request)
    {
        $response = [
            'code' => 402,
            'msg' => '服务器出错，请稍后再试',
        ];

        if ($this->guard()->user()->subscribe()->create($request->only('email'))) {
            $response = [
                'code' => 200,
                'msg' => '订阅成功',
            ];
        }

        return $response;
    }

    public function deSubscribe(Request $request)
    {
        $response = [
            'code' => 402,
            'msg' => '服务器出错，请稍后再试',
        ];

        if ($this->guard()->user()->subscribe()->delete()) {
            $response = [
                'code' => 200,
                'msg' => '取消订阅成功',
            ];
        }

        return $response;
    }


    public function uploadAvatar(Request $request)
    {
        if (! $request->hasFile('file')) {
            return [
                'code' => 302,
                'msg' => '没选择图片',
                'data' => []
            ];
        }

        // move file to public
        if (! $link = $request->file('file')->store(config('web.upload.avatar'), 'public')) {
            return [
                'code' => 402,
                'msg' => '服务器异常，请稍后再试',
                'data' => []
            ];
        }


        return [
            'code' => 0,
            'msg' => '图片上传成功',
            'data' => ['src' => $link]
        ];
    }


    public function showPasswordForm()
    {
        return view('user.users.password');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'old_password.required' => '旧密码不能为空',
            'password.required' => '新密码不能为空',
            'password.min' => '新密码必须大于6位',
            'password.confirmed' => '两次密码不一致',
        ]);

        if (! $this->validatePassword($request->input('old_password'))) {
            return back()->withErrors(['old_password' => '旧密码不正确']);
        }


        $user = $request->user();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return back()->with('status', '密码修改成功');
    }

    private function validatePassword($oldPassword)
    {
        return Hash::check($oldPassword, $this->guard()->user()->password);
    }

    protected function guard()
    {
        return Auth::guard();
    }


}
