<?php

namespace App\Http\Controllers\Home;

use App\Models\Cars;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarsController extends Controller
{
    protected $response = [
        'code' => 0,
        'msg' => ''
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
        $form_data = $this->getFormData($request);

        if (! $form_data['user_id']) {
            return $this->response = ['code' => 302, 'msg' => '你还没有登录'];
        }

        Cars::create($form_data);

        return $this->response = ['code' => 0, 'msg' => '加入购物车成功'];
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getFormData($request)
    {
        $form_data = $request->only('product_id');

        if (! $this->guard()->user()) {
            $form_data['user_id'] = null;
        } else {
            $form_data['user_id'] = $this->guard()->user()->id;
        }
        $form_data['numbers'] = 1;

        return $form_data;
    }

    private function guard()
    {
        return Auth::guard();
    }
}
