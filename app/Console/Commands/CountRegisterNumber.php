<?php

namespace App\Console\Commands;

use App\Models\SiteCount;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CountRegisterNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'count:registered';

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
        // 每天凌晨统计昨天的数据
        $date = Carbon::now()->subDay(1)->toDateString();

        $githubCount = Cache::get('site_counts:github_registered_count', 0);
        $qqCount = Cache::get('site_counts:qq_registered_count', 0);
        $weiboCount = Cache::get('site_counts:weibo_registered_count', 0);
        $moonCount = Cache::get('site_counts:moon_registered_count', 0);
        $registerCout = Cache::get('site_counts:registered_count', 0);


        // 防止一天运行多次，所以采用更新
        $site = SiteCount::query()->firstOrNew(compact('date'));
        $site->github_registered_count += $githubCount;
        $site->qq_registered_count += $qqCount;
        $site->weibo_registered_count += $weiboCount;
        $site->moon_registered_count += $moonCount;
        $site->registered_count += $registerCout;
        $site->save();
    }
}
