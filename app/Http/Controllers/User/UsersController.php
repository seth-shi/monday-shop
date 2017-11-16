<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\User;
use Auth;
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
        dd($request);
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


    protected function guard()
    {
        return Auth::guard();
    }
}
