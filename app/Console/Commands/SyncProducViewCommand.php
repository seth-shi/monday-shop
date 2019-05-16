<?php

namespace App\Console\Commands;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SyncProducViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:sync-product_view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $yesterday = Carbon::yesterday()->toDateString();

        $products = Product::query()->where('today_has_view', 1)->get();

        $products->map(function (Product $product) use ($yesterday) {


            $viewCount = Cache::pull($product->getViewCountKey($yesterday), 0);
            $product->view_count += $viewCount;
            $product->today_has_view = 0;
            $product->save();
        });

        createSystemLog("系统同步{$yesterday}商品浏览量", ['date' => $yesterday]);
    }
}
