<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ScoreLog;
use App\Models\ScoreRule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ScoreLogServe
{
    /**
     * 登录
     * @param User $user
     * @return bool
     */
    public function loginAddScore(User $user)
    {
        $now = Carbon::now();
        $today = Carbon::today();

        /**
         * @var $ids Collection
         * 每天都有一个登录用户的 key,通过定时任务删除
         * 如果这个用户已经记录过了,那么可以跳过
         */
        $cacheKey = $this->loginKey($today->toDateString());
        $ids = Cache::get($cacheKey, collect());
        if ($ids->contains($user->id)) {
            return false;
        }

        $ids->push($user->id);
        Cache::put($cacheKey, $ids, 60*24);

        // 登录总是送这么多积分
        $rule = ScoreRule::query()->where('index_code', ScoreRule::INDEX_LOGIN)->firstOrFail();

        $user->score_all += $rule->score;
        $user->score_now += $rule->score;

        $scoreLog = new ScoreLog();
        $scoreLog->rule_id = $rule->id;
        $scoreLog->user_id = $user->id;
        $scoreLog->score = $rule->score;
        $scoreLog->description = str_replace(
            ['%username%', '%time%'],
            [$user->name, $now->toDateTimeString()],
            $rule->description
        );
        $scoreLog->save();

        // 看是否达到连续登录的条件
        $lastLoginDate = Carbon::make($user->last_login_date);
        // 如果是连续登录,那么久就加多一天,否则重置为一天
        $user->login_days = $today->copy()->subDay()->eq($lastLoginDate) ? $user->login_days + 1 : 1;
        $user->last_login_date = $today->toDateString();


        // 看是否能达到连续登录送积分
        $continueLoginRule = ScoreRule::query()
                                      ->where('index_code', ScoreRule::INDEX_CONTINUE_LOGIN)
                                      ->where('max_times', $user->login_days)
                                      ->first();
        // 如果满足了连续登录的要求
        if ($continueLoginRule) {

            $firstDay = $today->copy()->subDay($continueLoginRule->max_times)->toDateString();

            $user->score_all += $continueLoginRule->score;
            $user->score_now += $continueLoginRule->score;

            $scoreLog = new ScoreLog();
            $scoreLog->rule_id = $continueLoginRule->id;
            $scoreLog->user_id = $user->id;
            $scoreLog->score = $continueLoginRule->score;
            $scoreLog->description = str_replace(
                ['%username%', '%start_date%', '%end_date%', '%days%'],
                [$user->name, $firstDay, $today->toDateString(), $continueLoginRule->max_times],
                $continueLoginRule->description
            );
            $scoreLog->save();
        }

        return $user->save();
    }

    /**
     * 浏览商品增加积分
     *
     * @param User    $user
     * @param Product $product
     * @return bool
     */
    public function browseProductAddScore(User $user, Product $product)
    {
        $today = Carbon::today();

        /**
         * @var $browseProducts Collection
         * @var $userBrowseProducts Collection
         * 每天都有一个登录用户的 key,通过定时任务删除
         * 如果这个用户已经记录过了,那么可以跳过
         */
        $cacheKey = $this->browseKey($today->toDateString());

        // 浏览的格式如下
        // ['user1_id' => [1, 2, 3, 4]]
        $browseProducts = Cache::get($cacheKey, collect());
        $userBrowseProducts = $browseProducts->get($user->id, collect());

        // 如果用户今天已经浏览过了这个商品,那么就不会再记录
        if ($userBrowseProducts->contains($product->id)) {
            return false;
        }

        $browseProducts->put($user->id, $userBrowseProducts->push($product->id));
        Cache::put($cacheKey, $browseProducts, 60*24);


        // 查询是否达到增加积分
        $rule = ScoreRule::query()
                         ->where('index_code', ScoreRule::INDEX_REVIEW_PRODUCT)
                         ->where('max_times', $userBrowseProducts->count())
                         ->first();


        if ($rule) {

            $user->score_all += $rule->score;
            $user->score_now += $rule->score;
            $user->save();

            $scoreLog = new ScoreLog();
            $scoreLog->rule_id = $rule->id;
            $scoreLog->user_id = $user->id;
            $scoreLog->score = $rule->score;
            $scoreLog->description = str_replace(
                ['%username%', '%date%', '%times%'],
                [$user->name, $today->toDateString(), $rule->max_times],
                $rule->description
            );
            $scoreLog->save();
        }
    }

    public function loginKey($date)
    {
        return "{$date}_login_users";
    }

    public function browseKey($date)
    {
        return "{$date}_browse_products";
    }
}
