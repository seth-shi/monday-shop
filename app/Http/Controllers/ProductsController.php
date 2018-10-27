<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPinYin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{

    /**
     * 商品列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // 随机查出一些商品展示
        $products = Product::query()->inRandomOrder()->take(9)->get(['id', 'name'])->split(3);
        $pinyins = ProductPinYin::query()->orderBy('pinyin')->pluck('pinyin');

        return view('products.index', compact('products', 'pinyins'));
    }


    /**
     * ajax 通过商品首字母查询商品
     * @param $pinyin
     * @return mixed
     */
    public function getProductsByPinyin($pinyin)
    {
        $products = Product::query()->where('first_pinyin', $pinyin)->get(['id', 'name'])->split(3);

        return $products;
    }


    /**
     * 商品搜索
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $products = Product::query()->where('name', 'like', "%{$keyword}%")->paginate(10);

        return view('products.search', compact('products'));
    }

    /**
     * 单个商品显示
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Product $product)
    {
        // 同类商品推荐
        $recommendProducts = Product::query()
                                    ->where('category_id', $product->category_id)
                                    ->take(5)
                                    ->get();

        // 加载出收藏的人数, 只查出第一页的人数，其他的 AJAX 获取
        $collects = $product->users()->get();

        return view('products.show', compact('product', 'recommendProducts', 'collects'));
    }

    /**
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
