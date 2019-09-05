<?php

namespace App\Models;

use App\Enums\ScoreRuleIndexEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\ScoreRule
 *
 * @property int $id
 * @property string $replace_text 获取积分的规则,描述文本,里面有可替换的标志量
 * @property string|null $description 这条规则的描述
 * @property string $index_code 连续登录送的积分, 查看商品数量送积分,
 * @property int $score 增加多少的积分
 * @property int $times 次数, 连续多少天的天数,查看商品的数量
 * @property int $can_delete 是否可以删除
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreRule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreRule whereCanDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreRule whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreRule whereIndexCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreRule whereReplaceText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreRule whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreRule whereTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScoreRule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
