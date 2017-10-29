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
        return [
           /* // products table field
            "category_id" => "required|exists:categories,id",
            "name" => "required|unique:products",
            "price" => "required",
            "price_original" => "required",

            // product_details table field
            "unit" => 'required',
            "count" => 'required',
            "description" => "required|min10",
           */

            // attribute table field
            "attribute" => 'required|array',
            "attribute.*" => 'required',
            "items" => 'required|array',
            "items.*" => 'required',
            "markup" => 'required|array',
            "markup.*" => 'required',

            // product_images table field
            "image" => 'required|array',

        ];
    }

    public function messages()
    {
        return [

            "attribute.required" => '商品的属性不能为空',
            "attribute.array" => '商品的属性不符合规格',
            "items.required" => '商品的属性的值不能为空',
            "items.array" => '商品的属性的值不符合规格',
            "markup.required" => '价格浮动不能为空',
            "markup.array" => '价格浮动不符合规格',
            "attribute.*.required" => '商品属性不能为空',
            "items.*.required" => '商品属性的值不能为空',
            "markup.*.required" => '商品价格浮动不能为空',

            "image.required" => '必须上传商品图片',
            "image.array" => '商品图片不符合规格',
        ];
    }
}
