<?php

namespace App\Utils;

use App\Enums\HomeCacheEnum;
use App\Enums\SettingKeyEnum;
use App\Models\Category;
use App\Models\CouponTemplate;
use App\Models\Product;
use App\Models\Seckill;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class HomeCacheDataUtil
{
    public static function couponTemplates()
    {
        return Cache::remember(
            HomeCacheEnum::COUPON_TEMPLATES,
            Carbon::now()->addMinutes(5),
            function () {

            $today = Carbon::today()->toDateString();
            return CouponTemplate::query()
                ->where('end_date', '>=', $today)
                ->latest()
                ->limit(3)
                ->get();
        });
    }

    public static function getSeckillData()
    {
        return Cache::remember(
            HomeCacheEnum::SEC_KILL_DATA,
            Carbon::now()->startOfSecond()->addSeconds(60),
            function () {

                $setting = new SettingKeyEnum(SettingKeyEnum::IS_OPEN_SECKILL);
                $isOpenSeckill = setting($setting) == 1;

                if ($isOpenSeckill) {

                    $now = Carbon::now()->toDateTimeString();
                    $secKills = Seckill::query()
                        ->where('start_at', '<=', $now)
                        ->where('end_at', '>', $now)
                        ->latest()
                        ->get();


                    $pipeline = Redis::connection()->pipeline();
                    $secKills->each(function (Seckill $seckill) use ($pipeline) {
                        $pipeline->get($seckill->getRedisModelKey());
                    });

                    return  collect($pipeline->execute())->map(function ($item) {

                        if (! $item) {
                            return null;
                        }

                        return json_decode($item);
                    })->filter(function ($model) {

                        if (! is_object($model)) {
                            return false;
                        }

                        if ($model->sale_count == $model->number) {
                            return false;
                        }

                        // 已经过期的秒杀
                        if (Carbon::now()->gt(Carbon::make($model->end_at))) {
                            return false;
                        }

                        return true;
                    })->values();
                }
            }
        );
    }

    public static function categories($ttl, $refresh = false)
    {
        if ($refresh) {
            Cache::forget(HomeCacheEnum::CATEGORIES);
        }

        return Cache::remember(
            HomeCacheEnum::CATEGORIES,
            Carbon::now()->addSeconds($ttl),
            function () {

                return Category::query()
                    ->withCount('products')
                    ->orderBy('order')
                    ->take(9)
                    ->get();
            });
    }

    public static function hotProducts($ttl, $refresh = false)
    {
        if ($refresh) {
            Cache::forget(HomeCacheEnum::HOTTEST);
        }

        return Cache::remember(
            HomeCacheEnum::HOTTEST,
            Carbon::now()->addSeconds($ttl),
            function () {

                return Product::query()
                    ->withCount('users')
                    ->orderBy('sale_count', 'desc')
                    ->take(3)
                    ->get();
            });
    }

    public static function latestProducts($ttl, $refresh = false)
    {
        if ($refresh) {
            Cache::forget(HomeCacheEnum::LATEST);
        }

        return Cache::remember(
            HomeCacheEnum::LATEST,
            Carbon::now()->addSeconds($ttl),
            function () {

                return Product::query()
                    ->withCount('users')
                    ->latest()
                    ->take(9)
                    ->get();
            });
    }

    public static function users($ttl, $refresh = false)
    {
        if ($refresh) {
            Cache::forget(HomeCacheEnum::USERS);
        }

        return Cache::remember(
            HomeCacheEnum::USERS,
            Carbon::now()->addSeconds($ttl),
            function () {

                return User::query()
                    ->orderBy('login_count', 'desc')
                    ->take(10)
                    ->get(['avatar', 'name']);
            });
    }
}