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
        /**
         * @var $user User
         */
        $user = auth()->user();

        $likesProducts = $user->products()
                              ->where('user_id', auth()->id())
                              ->withCount('users')
                              ->latest()
                              ->paginate(10);

        return view('user.products.likes', compact('likesProducts'));
    }


    public function toggle($uuid)
    {
        /**
         * @var $product Product
         */
        $product = Product::query()
                          ->where('uuid', $uuid)
                          ->firstOrFail();


        $user = auth()->id();

        if ($product->users()->where('user_id', $user)->exists()) {

            $product->users()->detach($user);

            return response()->json([
                'code' => 200,
                'msg' => '欢迎下次收藏'
            ]);
        }

        $product->users()->attach($user);

        return response()->json([
            'code' => 201,
            'msg' => '收藏成功'
        ]);
}
}
