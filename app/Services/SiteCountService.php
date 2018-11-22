<?php

namespace App\Services;

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
        $attributes = [
            // 注册信息
            'registered_count', 'github_registered_count', 'qq_registered_count', 'weibo_registered_count',
            // 订单量            , 销售数量                            销售金额
            'product_sale_count', 'product_sale_number_count', 'product_sale_money_count'
        ];

        foreach ($attributes as $key) {

            if ($isPull) {
                $value = Cache::pull("site_counts:{$key}");
            } else {
                $value = Cache::get("site_counts:{$key}");
            }

            $siteModel->{$key} += $value;
        }

        return $siteModel;
    }
}
