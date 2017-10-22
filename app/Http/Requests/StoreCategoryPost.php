<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryPost extends FormRequest
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
            'name' => 'required|unique:categories',
            'parent_id' => Rule::notIn(['-1'])
        ];

        if ($this->request->get('_method') == 'PUT') {

            $rules['name'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '分类名称不能为空',
            'name.unique' => '分类名已经存在',
            'parent_id.not_in' => '请选择一个分类'
        ];
    }
}
