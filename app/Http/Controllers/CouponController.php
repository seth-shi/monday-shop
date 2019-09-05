<?php

namespace App\Http\Controllers;

use App\Models\CouponTemplate;
use App\Models\ScoreLog;
use App\Models\User;
use App\Models\UserHasCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function store(Request $request)
    {
        $templateId = $request->input('template_id');

        /**
         * @var $user User
         */
        $user = auth()->user();
        if (is_null($user)) {

            return responseJsonAsUnAuthorized('请先登录再领取优惠券');
        }

        $template = CouponTemplate::query()->find($templateId);
        if (is_null($template)) {

            return responseJsonAsBadRequest('无效的优惠券');
        }

        // 判断优惠券是否过期
        $today = Carbon::today();
        $endDate = Carbon::make($template->end_date);
        if ($today->gt($endDate)) {

            return responseJsonAsBadRequest('优惠券已过期');
        }

        if ($user->score_now < $template->score) {

            return responseJsonAsBadRequest("积分不足{$template->score},请先去获取积分");
        }

        // 这里我会只让每个用户只能领取一张优惠券
        if ($user->coupons()->where('template_id', $templateId)->exists()) {

            return responseJsonAsBadRequest('你已经领取过优惠券了');
        }

        DB::beginTransaction();

        try {

            // 用户减少积分
            if ($template->score > 0) {

                $user->score_now -= $template->score;
                $user->save();
                // 生成积分日志
                $log = new ScoreLog();
                $log->user_id = $user->getKey();
                $log->description = "领取优惠券";
                $log->score = -1 * $template->score;
                $log->save();
            }

            // 开始领取优惠券
            $coupon = new UserHasCoupon();
            $coupon->template_id = $template->getKey();
            $coupon->user_id = $user->getKey();

            $coupon->title = $template->title;
            $coupon->amount = $template->amount;
            $coupon->full_amount = $template->full_amount;
            $coupon->start_date = $template->start_date;
            $coupon->end_date = $template->end_date;
            $coupon->save();

        } catch (\Exception $e) {

            DB::rollBack();
            return responseJsonAsServerError('服务器异常，请稍后再试');
        }

        DB::commit();

        return responseJson(200, '领取成功');
    }
}
