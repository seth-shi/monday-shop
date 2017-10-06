<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoginPost extends FormRequest
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
     * 验证规则
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account' => 'required',
            'password' => 'required|min:6',
        ];
    }

    /**
     * 提示消息处理
     *
     * @return array
     */
    public function messages()
    {
        return [
            'account.required' => '用户名不能为空',
            'password.required' => '密码不能为空',
            'password.min' => '密码不能少于六位',
        ];
    }
}
