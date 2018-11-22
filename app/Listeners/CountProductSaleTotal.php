<?php

namespace App\Listeners;

use App\Events\CountSale;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class CountProductSaleTotal
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
     * 统计销售的总价
     *
     * @param  CountSale  $event
     * @return void
     */
    public function handle(CountSale $event)
    {
        Cache::increment('site_counts:product_sale_money_count', $event->order->total);
    }
}
