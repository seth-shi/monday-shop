<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    protected $response = [
        'code' => 302,
        'msg' => '你还没有登录'
    ];

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
            $cars = $user->cars()->get();
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
            return $this->response;
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
        $car->numbers += $request->input('numbers', 1);
        $car->save();

        return $this->response = ['code' => 200, 'msg' => '加入购物车成功'];
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
            return $this->response;
        }

        return $this->response = ['code' => 0, 'msg' => '删除成功'];
    }
}
