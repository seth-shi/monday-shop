<?php

namespace App\Models;

use App\Enums\ScoreRuleIndexEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ScoreRule extends Model
{
    const CACHE_KEY = 'cache:score_rules';
    const OPEN_RULES = [
        ScoreRuleIndexEnum::VISITED_PRODUCT,
        ScoreRuleIndexEnum::CONTINUE_LOGIN
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
