<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderDetail;
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
        // 未付款设置为取消状态，
        $this->order->status = Order::STATUSES['UN_PAY_CANCEL'];
        $this->order->save();

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
