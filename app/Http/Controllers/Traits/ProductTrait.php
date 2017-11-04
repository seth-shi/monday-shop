<?php

namespace App\Http\Controllers\Traits;

use App\Jobs\ResizeProductImage;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait ProductTrait
{
    use ApiTrait;

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
        if ($link = $request->file($fieldName)->store(config('web.upload.detail'), 'public')) {

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
    public function uploadDetailImage(Request $request)
    {
        $fieldName = $request->input('fieldName') ?? 'product_image';

        if (true !== ($response = $this->validateFile($request, $fieldName))) {
            return $response;
        }

        // move file to public
        if ($link = $request->file($fieldName)->store(config('web.upload.detail'), 'public')) {

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

    /**
     * change product is alive
     * @param Request $request
     * @param Product $product
     */
    public function changeAlive(Request $request, Product $product)
    {
        $product->is_alive = ! $product->is_alive;
        if ($product->save()) {
            return $this->setCode(200)->setMsg('修改成功')->toJson();
        }

        return $this->setCode(401)->setMsg('服务器异常，请稍后再试')->toJson();
    }

    public function deleteImage(Request $request)
    {
        $productImage = ProductImage::find($request->input('id'));
        // delete file
        Storage::drive('public')->delete($productImage->link);

        if ($productImage->delete()) {
            return $this->setCode(200)->setMsg('删除成功')->toJson();
        } else {
            return $this->setCode(401)->setMsg('服务器异常，请稍后再试')->toJson();
        }
    }
}
