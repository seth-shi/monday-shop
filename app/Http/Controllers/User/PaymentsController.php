<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends ApiController
{
    public function pay(Request $request)
    {
        if (($validator = $this->validatePayParam($request->all()))->fails()) {
            return $this->setCode(303)->setMsg($validator->errors()->first());
        }



    }

    private function validatePayParam(array $data)
    {
        return Validator::make($data, [
            'price' => 'required|numeric',
            'istype' => 'in:1,2',
            'orderuid' => 'required|exists:users,id',
            'goodsname' => 'required|exists:products,name'
        ]);
    }
}
