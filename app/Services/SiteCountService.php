<?php

namespace App\Services;

use App\Enums\SiteCountCacheEnum;
use App\Models\SiteCount;
use Illuminate\Support\Facades\Cache;

class SiteCountService
{
    /**
     * 传入一个统计模型，同步缓存中的数据到模型中，并可选是否移除缓存中的值
     * @param SiteCount $siteModel
     * @param bool      $isPull
     * @return SiteCount
     */
    public function syncByCache(SiteCount $siteModel, $isPull = false)
    {
        $attributes = SiteCountCacheEnum::toArray();

        foreach ($attributes as $key) {

            if ($isPull) {
                $value = Cache::pull($key);
            } else {
                $value = Cache::get($key);
            }

            $key = str_replace('site_counts:', '', $key);
            $siteModel->{$key} += $value;
        }

        return $siteModel;
    }
}
