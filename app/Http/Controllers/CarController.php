<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('user.auth')->only('store', 'destroy');
    }

    /**
     * 购物车列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cars = collect();

        /**
         * @var $user User
         */
        if ($user = \auth()->user()) {
            // 直接获取当前登录用户的购物车
            $cars = $user->cars()->with('product')->get();
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
        $change = 0;
        $number = $request->input('number', 1);

        if ($request->input('action') == 'sync') {

            $change = $number - $car->number;
            $car->number = $number;
        } else {

            $car->number += $number;
        }

        if ($car->number > $product->count) {

            return responseJson(403, '库存不足');
        }


        $car->save();

        return responseJson(200, '加入购物车成功', compact('change'));
    }


    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        try {
            /**
             * @var $user User
             */
            $user = auth()->user();
            $car = $user->cars()->whereKey($id)->firstOrFail();
            $car->delete();

        } catch (\Exception $e) {

            dd($e);
            return responseJson(500, '服务器异常，请稍后再试');
        }

        return responseJson(200, '删除成功');
    }
}
