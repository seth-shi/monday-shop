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
    protected function hasRedis(): bool
    {
        return extension_loaded('redis') && class_exists('Redis');
    }

    protected function store()
    {
        if (!$this->hasRedis()) {
            return null;
        }
        return app('redis');
    }

    /**
     * 登录
     * @param User $user
     * @return bool
     */
    public function loginAddScore(User $user)
    {
        $now = Carbon::now();
        $today = Carbon::today();

        $bitKey = $this->loginKey($today->toDateString());

        $store = $this->store();
        if ($store) {
            $bitVal = $store->setBit($bitKey, $user->id, 1);
            if ($bitVal > 0) {
                return false;
            }
        }

        $rule = ScoreRule::query()->where('index_code', ScoreRuleIndexEnum::LOGIN)->firstOrFail();

        $user->score_all += $rule->score;
        $user->score_now += $rule->score;

        $scoreLog = new ScoreLog();
        $scoreLog->rule_id = $rule->id;
        $scoreLog->user_id = $user->id;
        $scoreLog->score = $rule->score;
        $scoreLog->description = str_replace(':time', $now->toDateTimeString(), $rule->replace_text);
        $scoreLog->save();

        $lastLoginDate = Carbon::make($user->last_login_date);
        $user->login_days = $today->copy()->subDay()->eq($lastLoginDate) ? $user->login_days + 1 : 1;
        $user->last_login_date = $today->toDateString();

        $continueLoginRule = ScoreRule::query()
                                      ->where('index_code', ScoreRuleIndexEnum::CONTINUE_LOGIN)
                                      ->where('times', $user->login_days)
                                      ->first();
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
        $store = $this->store();
        if (!$store) {
            return;
        }

        $today = Carbon::today();

        $bitKey = $this->visitedKey($today->toDateString(), $user->id);

        $bitVal = $store->setBit($bitKey, $product->id, 1);
        if ($bitVal > 0) {
            return;
        }

        $userViewCount = $store->bitCount($bitKey);
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
        $rule = ScoreRule::query()
                         ->where('index_code', ScoreRuleIndexEnum::COMPLETE_ORDER)
                         ->firstOrFail();

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
        $store = $this->store();
        if (!$store) {
            return 0;
        }

        $bitKey = $this->visitedKey($date, $userId);

        return (int)$store->bitCount($bitKey);
    }

    public function loginKey($date)
    {
        return "{$date}_login_bit_users";
    }

    public function visitedKey($date, $userId)
    {
        return "{$date}_visited_products:{$userId}";
    }
}