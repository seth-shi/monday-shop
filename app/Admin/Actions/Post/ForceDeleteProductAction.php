<?php

namespace App\Admin\Actions\Post;

use App\Models\Product;
use Encore\Admin\Actions\RowAction;
use Illuminate\Http\Request;

class ForceDeleteProductAction extends RowAction
{
    public $name = '删除';


    public function handle(Product $product)
    {
        $product->forceDelete();

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
