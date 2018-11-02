<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\User;
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
        $likesProducts = $this->user()->products()->withCount('users')->paginate(10);

        return view('user.products.likes', compact('likesProducts'));
    }


    public function toggle($id)
    {
        // likes or no likes
        $this->user()->products()->toggle($id);

        return $this->response = [
            'code' => 0,
            'msg' => '操作成功'
        ];
    }

    /**
     * @return User
     */
    protected function user()
    {
        return Auth::guard()->user();
    }
}
