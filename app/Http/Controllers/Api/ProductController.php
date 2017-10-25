<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class ProductController extends ApiController
{
    public function upload(Request $request)
    {
        $fieldName = 'product_image';

        if (true !== ($response = $this->validateFile($request, $fieldName))) {
            return $response;
        }

        // move file to public
        if ($link = $request->file($fieldName)->store('uploads/product', 'public')) {
            return $this->setMsg('文件上传成功')->setData(['src' => $link])->toJson();
        }

        return $this->setMsg('服务器出错，请稍后再试')->setCode(301)->toJson();
    }

    protected function validateFile($request, $fieldName)
    {
        if (! $request->hasFile($fieldName)) {
            return $this->setMsg('没有选择文件')->toJson();
        }

        if (! $request->file($fieldName)->isValid()) {
            return $this->setMsg('文件无效')->toJson();
        }

        return true;
    }
}
