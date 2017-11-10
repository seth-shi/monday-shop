<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'phone' => 'required',
            'province' => 'required',
            'city' => 'required',
            'region' => 'required',
            'detail_address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '收货人名字不能为空',
            'phone.required' => '手机号码不能为空',
            'province.required' => '省区不能为空',
            'city.required' => '城市不能为空',
            'region.required' => '区域不能为空',
            'detail_address.required' => '详细收货地址不能为空',
        ];
    }
}
