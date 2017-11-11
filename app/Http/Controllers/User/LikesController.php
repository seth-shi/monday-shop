<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikesController extends Controller
{
    protected $response = [
        'code' => 1,
        'msg' => '服务器异常，请稍后再试',
    ];


    public function index()
    {
        $likesProducts = $this->guard()->user()->products;

        return view('user.products.likes', compact('likesProducts'));
    }


    public function toggle($id)
    {
        // likes or no likes
        $this->guard()->user()->products()->toggle($id);

        return $this->response = [
            'code' => 0,
            'msg' => '操作成功'
        ];
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
