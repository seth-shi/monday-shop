<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * 购物车列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cars = collect();
        $addresses = collect();

        /**
         * @var $user User
         */
        if ($user = \auth()->user()) {
            // 直接获取当前登录用户的购物车
            $cars = $user->cars()->with('product')->get();
            $addresses = $user->addresses()->get();
        }

        return view('cars.index', compact('cars', 'addresses'));
    }

    /**
     * 添加购物车
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {

        // 没登录的加入购物车，直接加入 localStorage
        if (! auth()->check()) {
            return [
                'code' => 302,
                'msg' => '加入本地购物车成功'
            ];
        }

        /**
         * @var $car Car
         * @var $product Product
         * @var $user User
         */
        $product = Product::query()->where('uuid', $request->input('product_id'))->firstOrFail();

        $user = auth()->user();
        $car = $user->cars()->firstOrNew([
            'user_id' => \auth()->id(),
            'product_id' => $product->id
        ]);


        // 如果是同步，则只是赋值，如果是添加购物车则是添加
        if ($request->input('action') == 'sync') {
            $car->number = $request->input('number', 1);
        } else {
            $car->number += $request->input('number', 1);
        }


        if ($car->number > $product->count) {
            return [
                'code' => 403,
                'msg' => '库存不足'
            ];
        }


        $car->save();

        return ['code' => 200, 'msg' => '加入购物车成功'];
    }


    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function destroy($id)
    {
        if ($car = Car::query()->find($id)) {
            $car->delete();
        } else {
            return [
                'code' => 302,
                'msg' => '删除本地购物车成功'
            ];
        }

        return ['code' => 200, 'msg' => '删除成功'];
    }
}
