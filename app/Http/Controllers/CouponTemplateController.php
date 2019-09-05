<?php

namespace App\Http\Controllers;

use App\Models\CouponTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponTemplateController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // 只查询未过期的
        // 标记已经领取过的
        $templates = CouponTemplate::query()
            ->withCount(['coupons' => function ($b) {

                $b->where('user_id', auth()->id());
            }])
            ->where('end_date', '>=', $today)
            ->get();


        return view('coupons.templates', compact('templates'));
    }
}
