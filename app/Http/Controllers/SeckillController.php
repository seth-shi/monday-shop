<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Seckill;
use App\Models\User;
use Carbon\Carbon;

class SeckillController extends Controller
{
    public function show($id)
    {
        /**
         * @var $seckill Seckill
         * @var $product Product
         */
        $seckill = Seckill::query()->findOrFail($id);
        $product = $seckill->product()->firstOrFail();

        // 如果登录返回所有地址列表，如果没有，则返回一个空集合
        $addresses = collect()->when(auth()->user(), function ($coll, User $user) {
            return $user->addresses()->get();
        });

        $now = Carbon::now();
        $endAt = Carbon::make($seckill->end_at);
        $startAt = Carbon::make($seckill->start_at);

        if ($now->gt($endAt)) {

            abort(403, "秒杀已经结束");
        }

        // 秒杀是否已经开始
        $seckill->is_start = $now->gt($startAt);
        // 开始倒计时
        $seckill->diff_time = $startAt->getTimestamp() - time();




        return view('seckills.show', compact('seckill', 'product', 'addresses'));
    }
}
