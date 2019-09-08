<?php

namespace App\Jobs;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\UserHasCoupon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancelUnPayOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 查询数据库最新状态
        $nowOrder = $this->order->refresh();

        // 如果现在还是没有付款,那么则取消订单
        if ($nowOrder->status == OrderStatusEnum::UN_PAY) {

            // 如果订单还是没有付款
            // 未付款设置为取消状态，
            $this->order->status = OrderStatusEnum::UN_PAY_CANCEL;
            $this->order->save();

            // 回退优惠券
            if (
                !is_null($this->order->coupon_id) &&
                $coupon = UserHasCoupon::query()->find($this->order->coupon_id)
            ) {

                $coupon->used_at = null;
                $coupon->save();
            }

            // 回滚库存
            $this->order
                ->details()
                ->with('product')
                ->get()
                ->map(function (OrderDetail $detail) {

                    // 不回滚出售数量
                    $product = $detail->product;
                    $product->increment('count', $detail->number);
                });
        }
    }
}
