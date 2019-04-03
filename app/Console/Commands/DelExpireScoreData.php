<?php

namespace App\Console\Commands;

use App\Services\ScoreLogServe;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class DelExpireScoreData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:del-score-data';

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
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function handle()
    {
        // 获取昨天的日期
        $yesterday = Carbon::today()->subDay()->toDateString();

        $serve = new ScoreLogServe();

        Cache::delete($serve->loginKey($yesterday));
        Cache::delete($serve->visitedKey($yesterday));

        createSystemLog("系统删除{$yesterday}过期积分统计数据", ['date' => $yesterday]);
    }
}
