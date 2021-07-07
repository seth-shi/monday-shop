<?php

namespace App\Console\Commands;

use App\Enums\HomeCacheEnum;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Utils\HomeCacheDataUtil;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateCacheHomeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:update-home';

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
        // 每分钟有定时任务更新
        $ttl = 60 * 2;

        HomeCacheDataUtil::categories($ttl, true);
        HomeCacheDataUtil::hotProducts($ttl, true);
        HomeCacheDataUtil::latestProducts($ttl, true);
        HomeCacheDataUtil::users($ttl, true);
    }
}
