<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array'
        ];

        if ($this->method() == 'PUT') {
            $rules['name'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '角色名不能为空',
            'name.unique' => '角色名已经存在',
            'permission.required' => '权限不能为空',
            'permission.array' => '权限格式错误',
        ];
    }
}
