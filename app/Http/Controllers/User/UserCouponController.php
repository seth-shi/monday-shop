<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CouponCode;
use App\Models\CouponTemplate;
use App\Models\User;
use App\Models\UserHasCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserCouponController extends Controller
{
    public function index(Request $request)
    {
        /**
         * @var $user User
         */
        $user = auth()->user();

        $query = $user->coupons();

        switch ($request->input('tab', 1)) {

            // 可使用的
            case 1:
                $today = Carbon::today()->toDateString();
                $query->where('end_date', '>=', $today)->whereNull('used_at');
                break;
            // 已使用的
            case 2:
                $query->whereNotNull('used_at');
                break;
            // 未使用过期的
            case 3:
                $today = Carbon::today()->toDateString();
                $query->whereNull('used_at')->where('end_date', '<', $today);
                break;
        }

        $coupons = $query->latest()->paginate();

        $today = Carbon::today();
        foreach ($coupons as $coupon) {

            if (! is_null($coupon->used_at)) {

                $coupon->used = true;
                $coupon->show_title = '已使用';
            }
            // 过期的
            elseif ($today->gt(Carbon::make($coupon->end_date))) {

                $coupon->used = true;
                $coupon->show_title = '已过期';
            } else {

                $coupon->used = false;
                $coupon->show_title = '去使用';
            }

        }

        return view('user.coupons.index', compact('coupons'));
    }


    public function exchangeCoupon(Request $request)
    {
        $code = $request->input('code');
        if (strlen($code) !== 16) {

            return responseJsonAsBadRequest('兑换码必须是16位');
        }

        $codeModel = CouponCode::query()->where('code', $code)->first();
        if (is_null($codeModel)) {

            return responseJsonAsBadRequest('无效的兑换码');
        }

        $user = auth()->user();
        if ($codeModel->user_id != $user->id) {

            return responseJsonAsBadRequest('兑换码并非发放给你，请勿使用');
        }

        if (! is_null($codeModel->used_at)) {

            return responseJsonAsBadRequest('兑换码已使用');
        }

        /**
         * @var $template CouponTemplate
         */
        $template = $codeModel->template()->first();
        if (is_null($template)) {

            return responseJsonAsServerError('兑换码已过期');
        }

        $today = Carbon::today();
        if ($today->gt(Carbon::make($template->end_date))) {

            return responseJsonAsServerError('兑换码已过期');
        }


        $codeModel->used_at = Carbon::now()->toDateTimeString();
        $codeModel->save();

        // 开始领取优惠券
        $coupon = new UserHasCoupon();
        $coupon->template_id = $template->getKey();
        $coupon->user_id = $user->id;

        $coupon->title = $template->title;
        $coupon->amount = $template->amount;
        $coupon->full_amount = $template->full_amount;
        $coupon->start_date = $template->start_date;
        $coupon->end_date = $template->end_date;
        $coupon->save();


        return responseJson(200, "兑换{$template->title}成功");
    }
}
