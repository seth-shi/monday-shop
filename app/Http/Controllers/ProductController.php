<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPinYin;
use App\Models\User;
use App\Services\ScoreLogServe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    /**
     * 商品列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // 随机查出一些商品展示
        $products = Product::query()->inRandomOrder()->take(9)->get(['uuid', 'name'])->split(3);
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
        $products = Product::query()->withCount('users')->where('name', 'like', "%{$keyword}%")->paginate(10);

        return view('products.search', compact('products'));
    }

    /**
     * 单个商品显示
     *
     * @param $uuid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($uuid)
    {
        /**
         * @var $user User|null
         */
        $product = Product::query()->where('uuid', $uuid)->firstOrFail();
        $user = auth()->user();

        // 同类商品推荐
        $recommendProducts = Product::query()
                                    ->where('category_id', $product->category_id)
                                    ->take(5)
                                    ->get();

        // 加载出详情，收藏的人数, 评论
        $product->load([
            'detail',
            'users',
            'comments' => function ($query) {
                $query->latest();
            },
            'comments.user'
        ]);
        $product->userIsLike = $product->users()->where('id', auth()->id())->exists();

        // 如果登录返回所有地址列表，如果没有，则返回一个空集合
        $addresses = collect();
        $orderDetails = collect();
        if ($user) {

            $addresses = $user->addresses()->get();
            $orderDetails = $user->orderDetails()
                                 ->with('order')
                                 ->where('is_commented', 0)
                                 ->where('product_id', $product->id)
                                 ->get();

            // 浏览商品增加积分
            (new ScoreLogServe)->browseProductAddScore($user, $product);
        }

        return view('products.show', compact('product', 'addresses', 'recommendProducts', 'orderDetails'));
    }

    /**
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
