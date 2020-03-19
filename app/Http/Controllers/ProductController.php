<?php

namespace App\Http\Controllers;

use App\Models\Node;
use App\Models\Product;
use App\Models\ProductPinYin;
use App\Models\User;
use App\Services\ScoreLogServe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
        $page = abs((int)$request->get('page', 1));
        $limit = (int)$request->get('limit', 20);
        $offset = (int) ($page - 1) * $limit;
        
        // 全文索引
        try {
    
            $parameters = [
                'multi_match' => [
                    'query' => $keyword,
                    'fields' => ['title', 'body'],
                ]
            ];
            
            $count = Product::searchCount($parameters);
            $searchCount = $count['count'] ?? 0;
            $searchResult = Product::search($parameters, $limit, $offset);
            $filterIds = Collection::make($searchResult['hits']['hits'] ?? [])->pluck('_source.id');
            $models = Product::query()->findMany($filterIds);
    
            $products = new LengthAwarePaginator($models, $searchCount, $limit, $page);
            
        } catch (\Exception $e) {
    
            $products = Product::query()->withCount('users')->where('name', 'like', "%{$keyword}%")->paginate($limit);
        }

        return view('products.search', compact('products'));
    }

    /**
     * 单个商品显示
     *
     * @param                 $uuid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($uuid)
    {
        /**
         * @var $user User|null
         */
        $product = Product::query()->where('uuid', $uuid)->firstOrFail();


        if (! $product->today_has_view) {
            $product->today_has_view = true;
            $product->save();
        }
        // 直接使用缓存
        $today = Carbon::today()->toDateString();
        Cache::increment($product->getViewCountKey($today));


        // 商品浏览次数 + 1
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
        if ($user) {

            // 浏览商品增加积分
            (new ScoreLogServe)->visitedProductAddScore($user, $product);
        }

        return view('products.show', compact('product', 'addresses', 'recommendProducts'));
    }

    /**
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
