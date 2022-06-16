<?php

namespace App\Services;

use App\Enums\ScoreRuleIndexEnum;
use App\Models\Order;
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
        $bitKey = $this->loginKey($today->toDateString());

        // 使用 bitmap 计算是否登录
        // setbit 返回原来的值, 如果返回 1, 那么代表之前设置过了
        $bitVal = $this->store()->setBit($bitKey, $user->id, 1);
        if ($bitVal > 0) {
            return false;
        }

        // 每次登录总是送这么多积分
        $rule = ScoreRule::query()->where('index_code', ScoreRuleIndexEnum::LOGIN)->firstOrFail();

        $user->score_all += $rule->score;
        $user->score_now += $rule->score;

        $scoreLog = new ScoreLog();
        $scoreLog->rule_id = $rule->id;
        $scoreLog->user_id = $user->id;
        $scoreLog->score = $rule->score;
        $scoreLog->description = str_replace(':time', $now->toDateTimeString(), $rule->replace_text);
        $scoreLog->save();

        // 看是否达到连续登录的条件
        $lastLoginDate = Carbon::make($user->last_login_date);
        // 如果是连续登录,那么久就加多一天,否则重置为一天
        $user->login_days = $today->copy()->subDay()->eq($lastLoginDate) ? $user->login_days + 1 : 1;
        $user->last_login_date = $today->toDateString();


        // 看是否能达到连续登录送积分
        $continueLoginRule = ScoreRule::query()
                                      ->where('index_code', ScoreRuleIndexEnum::CONTINUE_LOGIN)
                                      ->where('times', $user->login_days)
                                      ->first();
        // 如果满足了连续登录的要求
        if ($continueLoginRule) {

            $firstDay = $today->copy()->subDay($continueLoginRule->times)->toDateString();

            $user->score_all += $continueLoginRule->score;
            $user->score_now += $continueLoginRule->score;

            $scoreLog = new ScoreLog();
            $scoreLog->rule_id = $continueLoginRule->id;
            $scoreLog->user_id = $user->id;
            $scoreLog->score = $continueLoginRule->score;
            $scoreLog->description = str_replace(
                [':start_date', ':end_date', ':days天'],
                [$firstDay, $today->toDateString(), $continueLoginRule->times],
                $continueLoginRule->replace_text
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
     * @return void
     */
    public function visitedProductAddScore(User $user, Product $product)
    {
        $today = Carbon::today();

        /**
         * 每天都有一个登录用户的 key,通过定时任务删除
         * 如果这个用户已经记录过了,那么可以跳过
         */
        $bitKey = $this->visitedKey($today->toDateString(), $user->id);

        // 使用 bitmap 计算是否登录
        // setbit 返回原来的值, 如果返回 1, 那么代表之前设置过了
        $bitVal = $this->store()->setBit($bitKey, $product->id, 1);
        if ($bitVal > 0) {
            return;
        }

        $userViewCount = $this->store()->bitCount($bitKey);
        // 查询是否达到增加积分
        $rule = ScoreRule::getByCode(ScoreRuleIndexEnum::VISITED_PRODUCT, $userViewCount);
        if ($rule) {

            $user->score_all += $rule->score;
            $user->score_now += $rule->score;
            $user->save();

            $scoreLog = new ScoreLog();
            $scoreLog->rule_id = $rule->id;
            $scoreLog->user_id = $user->id;
            $scoreLog->score = $rule->score;
            $scoreLog->description = str_replace(
                [':date', ':number'],
                [$today->toDateString(), $rule->times],
                $rule->replace_text
            );
            $scoreLog->save();
        }
    }

    /**
     * 完成订单增加积分
     *
     * @param Order $order
     */
    public function completeOrderAddScore(Order $order)
    {
        // 订单完成增加积分
        $rule = ScoreRule::query()
                         ->where('index_code', ScoreRuleIndexEnum::COMPLETE_ORDER)
                         ->firstOrFail();

        // 计算积分和钱的比例
        $addScore = ceil($order->amount * $rule->score);

        $user = $order->user;
        $user->score_all += $addScore;
        $user->score_now += $addScore;
        $user->save();

        $scoreLog = new ScoreLog();
        $scoreLog->rule_id = $rule->id;
        $scoreLog->user_id = $user->id;
        $scoreLog->score = $addScore;
        $scoreLog->description = str_replace(
            [':time', ':no'],
            [Carbon::now()->toDateTimeString(), $order->no],
            $rule->replace_text
        );
        $scoreLog->save();
    }

    /**
     * 获取用户浏览器的数量
     * @param $date
     * @param $userId
     * @return int
     */
    public function getUserVisitedNumber($date, $userId)
    {
        $bitKey = $this->visitedKey($date, $userId);

        return (int)$this->store()->bitCount($bitKey);
    }

    public function loginKey($date)
    {
        return "{$date}_login_bit_users";
    }

    public function visitedKey($date, $userId)
    {
        return "{$date}_visited_products:{$userId}";
    }

    /**
     * @return \Redis
     */
    protected function store()
    {
        return app('redis');
    }
}
