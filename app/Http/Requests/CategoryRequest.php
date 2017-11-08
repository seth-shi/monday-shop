<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            'thumb' => 'required',
            'parent_id' => Rule::notIn(['-1']),
            'description' => 'required|min:10',
        ];

        if ($this->method() == 'PUT') {
            $rules['name'] = 'required';
            $rules['thumb'] = '';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '分类名称不能为空',
            'name.unique' => '分类名已经存在',
            'thumb.required' => '请选择分类缩略图',
            'parent_id.not_in' => '请选择一个分类',
            'description.required' => '分类描述不能为空',
            'description.min' => '分类描述不能少于10个字',
        ];
    }
}
