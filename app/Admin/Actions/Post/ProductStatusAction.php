<?php

namespace App\Admin\Actions\Post;

use App\Models\Product;
use Encore\Admin\Actions\RowAction;
use Illuminate\Http\Request;

class ProductStatusAction extends RowAction
{
    public $name = '';

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function handle(Product $product)
    {
        // $model ...
        // 如果商品已经下架
        if ($product->trashed()) {

            // 重新上架
            $product->restore();
        } else {

            $product->delete();
        }


        return $this->response()->success('操作成功.')->refresh();
    }


    public function retrieveModel(Request $request)
    {
        if (!$key = $request->get('_key')) {
            return false;
        }

        return Product::query()->withTrashed()->findOrFail($key);
    }
}
