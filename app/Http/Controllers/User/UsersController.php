<?php

namespace App\Http\Controllers\User;

use App\Exceptions\UploadException;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Services\UploadServe;
use Auth;
use Hash;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index()
    {

        $user = $this->user();
        $user->cars_count = $user->cars()->count();
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
        $this->validate($request, [
            'avatar' => 'required',
            'sex' => 'in:0,1',
            'name' => 'required|unique:users,name,' . auth()->id()
        ], [
           'avatar.required' => '头像不能为空',
           'sex.in' => '性别格式不对',
           'name.required' => '用户名不能为空',
           'name.unique' => '用户名已经存在',
        ]);

        $this->user()->update($request->only(['avatar', 'name', 'sex']));

        return back()->with('status', '修改成功');
    }


    public function subscribe(Request $request)
    {
        $response = [
            'code' => 402,
            'msg' => '服务器出错，请稍后再试',
        ];

        if ($this->user()->subscribe()->create($request->only('email'))) {
            $response = [
                'code' => 200,
                'msg' => '订阅成功',
            ];
        }

        return $response;
    }

    public function deSubscribe()
    {
        $response = [
            'code' => 402,
            'msg' => '服务器出错，请稍后再试',
        ];

        if ($this->user()->subscribe()->delete()) {
            $response = [
                'code' => 200,
                'msg' => '取消订阅成功',
            ];
        }

        return $response;
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
