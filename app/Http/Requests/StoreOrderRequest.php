<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
            'address_id' => ['required', Rule::exists('addresses', 'id')->where('user_id', auth()->id())],

            // 只有是单个商品下单，才需要验证这两个规则
            'product_id' => 'sometimes|exists:products,uuid',
            'numbers' => 'sometimes|integer',
        ];
    }
}
