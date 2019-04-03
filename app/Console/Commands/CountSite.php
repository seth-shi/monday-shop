<?php

namespace App\Console\Commands;

use App\Models\SiteCount;
use App\Services\SiteCountService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CountSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:count-site';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '统计数据，直接执行会统计到昨天';

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
     * @param SiteCountService $service
     * @return mixed
     */
    public function handle(SiteCountService $service)
    {
        // 每天凌晨统计昨天的数据
        $date = Carbon::now()->subDay(1)->toDateString();

        /**
         * 防止一天运行多次，所以采用增加
         *
         * @var $site SiteCount
         */
        $site = SiteCount::query()->firstOrNew(compact('date'));
        $site = $service->syncByCache($site, true);
        $site->save();

        createSystemLog('系统统计站点数据', $site->toArray());
    }
}
