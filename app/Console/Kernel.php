<?php

namespace App\Console;

use App\Console\Commands\CountSite;
use App\Console\Commands\DelExpireScoreData;
use App\Console\Commands\DelExpireSecKill;
use App\Console\Commands\SendSubscribeEmail;
use App\Console\Commands\SyncProducViewCommand;
use App\Console\Commands\UpdateCacheHomeData;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // 每周六八点发送订阅邮件
        $schedule->command(SendSubscribeEmail::class)->saturdays()->at('8:00');
        // 每天统计注册人数, 销售数量
        $schedule->command(CountSite::class)->dailyAt('01:00');
        // 每小时执行一次, 回滚秒杀过期的数据
        $schedule->command(DelExpireSecKill::class)->hourly();

        // 每天夜里十二点执行删除昨天过期的积分数据
        $schedule->command(DelExpireScoreData::class)->dailyAt('00:00');
        // 每天夜里十二点同步商品浏览量
        $schedule->command(SyncProducViewCommand::class)->dailyAt('00:10');

        // 每分钟更新一次首页数据
        $schedule->command(UpdateCacheHomeData::class)->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
