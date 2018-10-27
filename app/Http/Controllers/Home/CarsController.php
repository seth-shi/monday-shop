<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $cars = [];
        if ($this->guard()->check()) {
            // 直接获取当前登录用户的购物车
            $cars = $this->user()->cars()->get();
        }

        return view('cars.index', compact('cars'));
    }

    /**
     * 添加购物车
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        if ($this->isGreaterStock($request->all())) {
            return [
                'code' => 304,
                'msg' => '加入购物车的数量大于库存量'
            ];
        }

        if (! $this->guard()->check()) {
            return $this->response;
        }

        $form_data = $this->getFormData($request);

        /**
         * @var $car Car
         */
        $user = $this->user();
        $car = $user->cars()->where('product_id', $form_data['product_id'])->first();
        // 如果购物车已经存在，则添加数量，否则创建购物车
        if ($car) {
            $car->increment('numbers', $form_data['numbers']);
        } else {
            Car::query()->create($form_data);
        }

        // 加入购物车成功，减少商品数量
        ProductDetail::query()->where('product_id', $form_data['product_id'])
            ->lockForUpdate()
            ->first()
            ->decrement('count', $form_data['numbers']);

        return $this->response = ['code' => 0, 'msg' => '加入购物车成功'];
    }


    /**
     * 购买的数量是否超过库存
     *
     * @param array $data
     * @return bool
     */
    protected function isGreaterStock(array $data)
    {
        // buy numbers > count
        $product = Product::query()->find($data['product_id']);

        if ($data['numbers'] > $product->productDetail->count) {
            return true;
        }

        return false;
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

    /**
     * @param $request
     * @return mixed
     */
    private function getFormData(Request $request)
    {
        $form_data = $request->only('product_id');
        $form_data['user_id'] = $this->user()->getKey();
        $form_data['numbers'] = $request->input('numbers', 1);

        return $form_data;
    }

    /**
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    private function guard()
    {
        return Auth::guard();
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable | User
     */
    protected function user()
    {
        return $this->guard()->user();
    }
}
