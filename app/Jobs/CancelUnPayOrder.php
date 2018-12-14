<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;

class CancelUnPayOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $details;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order, Collection $details)
    {
        $this->order = $order;
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 未付款设置为取消状态，
        $this->order->status = Order::PAY_STATUSES['UN_PAY_CANCEL'];
        $this->order->save();

        // 回滚库存
        $this->details->map(function (OrderDetail $detail) {

            $detail->product->increment('count', $detail->numbers);
        });
    }
}
