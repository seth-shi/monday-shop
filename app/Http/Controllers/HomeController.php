<?php

namespace App\Http\Controllers;

use App\Enums\SettingKeyEnum;
use App\Models\Subscribe;
use App\Models\User;
use App\Utils\HomeCacheDataUtil;

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
        $ttl = 120 + mt_rand(10, 30);
        $categories = HomeCacheDataUtil::categories($ttl);
        $hotProducts = HomeCacheDataUtil::hotProducts($ttl);
        $latestProducts = HomeCacheDataUtil::latestProducts($ttl);
        $users = HomeCacheDataUtil::users($ttl);

        // 秒杀数据
        $secKills = HomeCacheDataUtil::getSeckillData();

        /**
         * 当前登录用户
         *
         * @var $loginUser User
         */
        if ($loginUser = auth()->user()) {

            $loginUser->load('subscribe');
        }

        // 查询优惠券
        $couponTemplates = HomeCacheDataUtil::couponTemplates();

        $setting = new SettingKeyEnum(SettingKeyEnum::IS_OPEN_SECKILL);
        $isOpenSeckill = setting($setting) == 1;

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
