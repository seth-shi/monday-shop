<?php

namespace App\Http\Controllers\Home;

use App\Models\Car;
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
        if (! $this->guard()->check()) {
            return $this->response;
        }

        $form_data = $this->getFormData($request);

        if ($car = $this->guard()->user()->cars()->where('product_id', $form_data['product_id'])->first()) {
            $car->increment('numbers', $form_data['numbers']);
        } else {
            Car::create($form_data);
        }

        return $this->response = ['code' => 0, 'msg' => '加入购物车成功'];
    }



    public function destroy(Car $car)
    {
        if (! $this->guard()->check()) {
            return $this->response;
        }

        dd($car);
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
