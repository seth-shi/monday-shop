<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImagesController extends Controller
{
    /**
     * 商品图片列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $productImages = ProductImage::all();

        return view('admin/productImages/index', compact('productImages'));
    }

    /**
     * 删除商品图片
     *
     * @param ProductImage $productImage
     * @return array
     * @throws \Exception
     */
    public function destroy(ProductImage $productImage)
    {
        $msg = [
            'code' => 200,
            'msg' => '删除成功'
        ];

        // 如果图片多于一张是可以删除的，否则不行。至少要留一张图片
        if (ProductImage::query()->where('product_id', $productImage->product_id)->count() > 1) {
            $productImage->delete();
        } else {
            $msg = [
                'code' => 301,
                'msg' => '此商品的最后一张图片了，不能删除'
            ];
        }

        return $msg;
    }
}
