<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            // products table field
            "category_id" => "required|exists:categories,id",
            "name" => "required|unique:products",
            "title" => "required|max:50",
            "price" => "required|numeric",
            "original_price" => "required|numeric",

            // product_details table field
            "unit" => 'required',
            "count" => 'required|numeric',
            "description" => "required|min:10",


            // attribute table field
            "attribute" => 'required|array',
            "attribute.*" => 'required',
            "items" => 'required|array',
            "items.*" => 'required',
            "markup" => 'required|array',
            "markup.*" => 'required|numeric',

            // product_images table field
            "link" => 'required|array',
        ];

        if ($this->method() == 'PUT') {
            $rules['name'] = 'required';
        }


        return $rules;
    }

    public function messages()
    {
        return [
            "category_id.required" => "请选择商品分裂",
            "category_id.exists" => "请选择一个正确的分类",
            "name.required" => "商品名字不能为空",
            "name.unique" => "商品名字已经存在",
            "title.required" => "商品描述不能为空",
            "title.max" => "商品描述不能大于50个字",
            "price.required" => "商品销售价格不能为空",
            "price.numeric" => "商品销售价格必须是数字",
            "original_price.required" => "商品展示价格不能为空",
            "original_price.numeric" => "商品展示价格必须是数字",

            "unit.required" => '商品计数单位不能为空',
            "count.required" => '商品库存量不能为空',
            "count.numeric" => '商品库存量必须是数字',
            "description.required" => "商品详情不能为空",
            "description.min" => "商品详情请在10个字以上",

            "attribute.required" => '商品的属性不能为空',
            "attribute.array" => '商品的属性不符合规格',
            "items.required" => '商品的属性的值不能为空',
            "items.array" => '商品的属性的值不符合规格',
            "markup.required" => '价格浮动不能为空',
            "markup.array" => '价格浮动不符合规格',
            "attribute.*.required" => '商品属性不能为空',
            "items.*.required" => '商品属性的值不能为空',
            "markup.*.required" => '商品价格浮动不能为空',
            "markup.*.numeric" => '商品价格浮动必须是数字',

            "link.required" => '必须上传商品图片',
            "link.array" => '商品图片不符合规格',
        ];
    }
}
