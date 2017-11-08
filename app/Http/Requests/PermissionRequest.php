<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'name' => 'required|unique:permissions,name'
        ];

        if ($this->method() == 'PUT') {
            $rules['name'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '权限名称不能为空',
            'name.unique' => '权限已存在'
        ];
    }
}
