<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        $rules = [
            'name' => 'required|unique:admins',
            'password' => 'required|min:6|confirmed',
            'roles' => 'required|array'
        ];

        if ($this->method() == 'PUT') {
            $rules['name'] = 'required';
            $rules['password'] = '';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '管理员名字不能为空',
            'name.unique' => '管理员名字已经存在',
            'password.required' => '密码不能为空',
            'password.min' => '密码最少六位',
            'password.confirmed' => '两次密码不相同',
            'roles.required' => '角色不能为空',
            'roles.array' => '角色不符合规范',
        ];
    }
}
