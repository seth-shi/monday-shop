<?php

namespace App\Listeners;

use App\Events\CountSale;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class CountProductSaleNumber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CountSale  $event
     * @return void
     */
    public function handle(CountSale $event)
    {
        // 统计销售的数量
        Cache::increment('site_counts:product_sale_money_count', $event->order->total);
    }
}
