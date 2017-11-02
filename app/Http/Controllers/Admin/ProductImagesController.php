<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productImages = ProductImage::all();

        return view('admin/productImages/index', compact('productImages'));
    }

    public function destroy(ProductImage $productImage)
    {
        $msg = [
            'code' => 200,
            'msg' => '删除成功'
        ];

        // The first judgment is not the last picture
        if (ProductImage::where('product_id', $productImage->product_id)->count() > 1) {
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
