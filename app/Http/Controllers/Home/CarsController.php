<?php

namespace App\Http\Controllers\Home;

use App\Models\Car;
use App\Models\Product;
use App\Models\ProductDetail;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarsController extends Controller
{
    protected $response = [
        'code' => 302,
        'msg' => '你还没有登录'
    ];

    public function index()
    {
        $cars = [];
        if ($this->guard()->check()) {
            $cars = $this->guard()->user()->cars;
        }

        return view('home.cars.index', compact('cars'));
    }


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

        if ($car = $this->guard()->user()->cars()->where('product_id', $form_data['product_id'])->first()) {
            $car->increment('numbers', $form_data['numbers']);
        } else {
            Car::create($form_data);
        }

        // Reduce inventory
        ProductDetail::where('product_id', $form_data['product_id'])
            ->lockForUpdate()
            ->first()
            ->decrement('count', $form_data['numbers']);

        return $this->response = ['code' => 0, 'msg' => '加入购物车成功'];
    }


    protected function isGreaterStock(array $data)
    {
        // buy numbers > count
        $product = Product::find($data['product_id']);

        if ($data['numbers'] > $product->productDetail->count) {
            return true;
        }

        return false;
    }

    public function destroy($id)
    {
        if ($car = Car::find($id)) {
            $car->delete();
        } else {
            return $this->response;
        }

        return $this->response = ['code' => 0, 'msg' => '删除成功'];
    }

    private function getFormData($request)
    {
        $form_data = $request->only('product_id');
        $form_data['user_id'] = $this->guard()->user()->id;
        $form_data['numbers'] = $request->input('numbers', 1);

        return $form_data;
    }

    private function guard()
    {
        return Auth::guard();
    }
}
