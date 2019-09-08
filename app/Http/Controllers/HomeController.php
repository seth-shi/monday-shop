<?php

namespace App\Http\Controllers;

use App\Enums\HomeCacheEnum;
use App\Enums\SettingKeyEnum;
use App\Enums\SiteCountCacheEnum;
use App\Models\Category;
use App\Models\CouponTemplate;
use App\Models\Product;
use App\Models\Seckill;
use App\Models\Subscribe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\URL;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    /**
     * 首页显示的数据
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // 取出后台排序好的九个分类，并且关联出商品的总数
        // 如没有 key，存入缓存中，防止用户未配置好任务调度确访问首页
        // 数据将不会从首页更新，每分钟任务调度更新，请务必配置好
        $categories = Cache::rememberForever(HomeCacheEnum::CATEGORIES, function () {

            return Category::query()->withCount('products')->orderBy('order')->take(9)->get();
        });
        $hotProducts = Cache::rememberForever(HomeCacheEnum::HOTTEST, function () {

            return Product::query()->withCount('users')->orderBy('sale_count', 'desc')->take(3)->get();
        });
        $latestProducts = Cache::rememberForever(HomeCacheEnum::LATEST, function () {

            return Product::query()->withCount('users')->latest()->take(9)->get();
        });
        $users = Cache::rememberForever(HomeCacheEnum::USERS, function () {

            return User::query()->orderBy('login_count', 'desc')->take(10)->get(['avatar', 'name']);
        });

        // 秒杀数据
        $secKills = collect();

        $setting = new SettingKeyEnum(SettingKeyEnum::IS_OPEN_SECKILL);
        $isOpenSeckill = setting($setting) == 1;

        if ($isOpenSeckill) {


            // 只要秒杀没有结束，都要查出来。且还有数量的
            $keys = Redis::keys('seckills:*:model');

            // 只有当有 key 的时候,采取通过 mget 取,否则会产生错误
            $secKills = $secKills->when($keys, function (Collection $collection, $keys) {

                $secKills = Redis::connection()->mget($keys);

                // 处理 redis 中的秒杀数据
                $now = Carbon::now();
                return $collection->union($secKills)
                                  ->map(function ($json) {

                                      return json_decode($json);
                                  })
                                  ->filter(function ($model) use ($now) {

                                      // 已经抢完的秒杀数量
                                      if ($model->sale_count == $model->number) {
                                          return false;
                                      }

                                      // 已经过期的秒杀
                                      if ($now->gt(Carbon::make($model->end_at))) {
                                          return false;
                                      }

                                      return true;
                                  });
            });
        }


        /**
         * 当前登录用户
         *
         * @var $loginUser User
         */
        if ($loginUser = auth()->user()) {

            $loginUser->load('subscribe');
        }



        // 查询优惠券
        $couponTemplates = Cache::rememberForever(HomeCacheEnum::COUPON_TEMPLATES, function () {

            $today = Carbon::today()->toDateString();
            return CouponTemplate::query()->where('end_date', '>=', $today)->latest()->limit(3)->get();
        });


        return view(
            'homes.index',
            compact('categories', 'hotProducts', 'latestProducts', 'users', 'secKills', 'loginUser', 'isOpenSeckill', 'couponTemplates')
        );
    }


    public function unSubscribe($email)
    {

        try {
            $email = decrypt($email);
        } catch (\Exception $e) {

            return view('hint.error', ['status' => '未知的账号']);
        }

        Subscribe::query()->where('email', $email)->update(['is_subscribe' => 0]);
        return view('hint.success', ['status' => '已取消订阅']);
    }
}
