<?php

namespace App\Http\Controllers\User;

use App\Exceptions\UploadException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOwnRequest;
use App\Models\Product;
use App\Models\User;
use App\Services\UploadServe;
use Auth;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {

        $user = $this->user();
        $user->cars_count = $user->cars()->sum('number');
        $user->orders_count = $user->orders()->count();
        $user->likeProducts = $user->products()->latest()->take(9)->get();

        $hotProduct = Product::query()->where('safe_count', 'desc')->first();

        return view('user.homes.index', compact('user', 'hotProduct'));
    }



    public function setting()
    {
        $user = $this->user();

        return view('user.users.setting', compact('user'));
    }



    public function update(Request $request)
    {
        $user = $this->user();

        $this->validate($request, [
            'avatar' => 'required',
            'sex' => 'in:0,1',
        ], [
           'avatar.required' => '头像不能为空',
           'sex.in' => '性别格式不对',
        ]);

        // 除了第三方授权登录的用户导致没有名字之外
        // 其他用户是不允许修改用户名和邮箱
        $user->sex= $request->input('sex');
        $user->avatar= $request->input('avatar');


        // 如果当前用户第一次修改用户名
        if ($user->is_init_name && $request->filled('name')) {

            $name = $request->input('name');

            if (User::query()->where('name', $name)->exists()) {

                return back()->withErrors('用户名已经存在');
            }

            $user->name = $name;
            $user->is_init_name = false;
        }

        // 如果当前用户第一次修改邮箱
        if ($user->is_init_email && $request->filled('email')) {

            $email = $request->input('email');

            if (User::query()->where('email', $email)->exists()) {

                return back()->withErrors('邮箱已经存在');
            }

            $user->email = $email;
            $user->is_init_email = false;
        }

        // 初始用户可以修改邮箱
        $user->save();

        return back()->with('status', '修改成功');
    }


    public function subscribe(Request $request)
    {
        $query = $this->user()->subscribe();

        // 取消订阅
        if ((clone $query)->exists()) {

            $query->delete();

            return responseJson(200, '取消订阅成功');
        }

        // 订阅邮件
        $query->create($request->only('email'));

        return responseJson(201, '订阅成功');
    }

    /**
     * 用户上传头像
     *
     * @param UploadServe $uploadServe
     * @return array
     */
    public function uploadAvatar(UploadServe $uploadServe)
    {
        $disk = 'public';

        try {
            $link = $uploadServe->setFileInput('file')
                                ->setMaxSize('5M')
                                ->setExtensions(['jpg', 'jpeg', 'png', 'bmp', 'gif'])
                                ->validate()
                                ->store('avatars', compact('disk'));

        } catch (UploadException $e) {

            return [
                'code' => 302,
                'msg' => $e->getMessage(),
                'data' => []
            ];
        }


        return [
            'code' => 0,
            'msg' => '图片上传成功',
            'data' => ['src' => $link, 'link' => \Storage::url($link)]
        ];
    }


    public function showPasswordForm()
    {
        $user = $this->user();

        return view('user.users.password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ], [
            'old_password.required' => '旧密码不能为空',
            'password.required' => '新密码不能为空',
            'password.min' => '新密码必须大于6位',
            'password.confirmed' => '两次密码不一致',
        ]);

        $user = $request->user();
        // 如果是从未设置过密码就就不用验证旧密码
        if (! $user->is_init_password && ! $this->validatePassword($request->input('old_password'))) {
            return back()->withErrors(['old_password' => '旧密码不正确']);
        }

        // 设置过密码之后，再也不是初始密码
        $user->is_init_password = false;
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return back()->with('status', '密码修改成功');
    }

    private function validatePassword($oldPassword)
    {
        return Hash::check($oldPassword, $this->user()->password);
    }

    /**
     * @return User|null
     */
    protected function user()
    {
        return auth()->user();
    }


}
