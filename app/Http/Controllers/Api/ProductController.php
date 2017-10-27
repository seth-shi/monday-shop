<?php

namespace App\Http\Controllers\Api;

use App\Jobs\ResizeProductImage;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    /**
     * product all image upload
     * @param Request $request
     * @return array|bool
     */
    public function upload(Request $request)
    {
        $fieldName = $request->input('fieldName') ?? 'product_image';

        if (true !== ($response = $this->validateFile($request, $fieldName))) {
            return $response;
        }

        // move file to public
        if ($link = $request->file($fieldName)->store('uploads/product/list', 'public')) {

            // upload after event
            $this->uploaded($link);

            return $this->setMsg('文件上传成功')->setCode(0)->setData(['src' => $link])->toJson();
        }

        return $this->setMsg('服务器出错，请稍后再试')->setCode(301)->toJson();
    }

    /**
     * Product description image upload
     * @param Request $request
     * @return array|bool
     */
    protected function uploadDetailImage(Request $request)
    {
        $fieldName = $request->input('fieldName') ?? 'product_image';

        if (true !== ($response = $this->validateFile($request, $fieldName))) {
            return $response;
        }

        // move file to public
        if ($link = $request->file($fieldName)->store('uploads/product/description', 'public')) {

            return $this->setMsg('文件上传成功')->setCode(0)->setData(['src' => '/storage/' . $link])->toJson();
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

    protected function uploaded($link)
    {
        dispatch(new ResizeProductImage($link));
    }
}
