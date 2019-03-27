<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ScoreRule extends Model
{
    //
    const INDEX_CONTINUE_LOGIN = 'multi_login_score';
    const INDEX_REVIEW_PRODUCT = 'review_product';
    const INDEX_COMPLETE_ORDER = 'complete_order';
    const INDEX_LOGIN = 'login_score';
    const INDEX_REGISTER = 'register_score';

    const CACHE_KEY = 'cache:score_rules';
    const OPEN_RULES = [
        self::INDEX_REVIEW_PRODUCT,
        self::INDEX_CONTINUE_LOGIN
    ];



    public static function boot()
    {
        parent::bootTraits();

        // 每当规则修改的时候, 移除掉缓存
        self::saved(function () {
            Cache::forget(self::CACHE_KEY);
        });
        self::deleted(function () {
            Cache::forget(self::CACHE_KEY);
        });
    }
}
