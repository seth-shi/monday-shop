<?php

namespace App\Services;

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
        $cacheKey = "{$today->toDateString()}_login_users";
        $ids = Cache::get($cacheKey, collect());
        if ($ids->contains($user->id)) {
            return false;
        }
        $ids->push($user->id);
        Cache::put($cacheKey, $ids);

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

        $user->save();
    }
}
