<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminPost extends FormRequest
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
            'name' => 'required|min:3',
            'password' => 'required|min:5',
            'captcha' => 'required|captcha',
        ];
    }

    public function messages()
    {
        return [
          'name.required' => '用户名不能为空',
          'name.min' => '用户名不能少于五位',
          'password.required' => '密码不能少于五位',
          'password.min' => '密码不能少于五位',
          'captcha.required' => '验证码不能为空',
          'captcha.captcha' => '验证码不正确',
        ];
    }
}
