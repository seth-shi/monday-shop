<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        return view('user.coupons.index', compact('coupons'));
    }
}
