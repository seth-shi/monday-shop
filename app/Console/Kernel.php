<?php

namespace App\Console;

use App\Console\Commands\CountRegisterNumber;
use App\Console\Commands\CountSite;
use App\Console\Commands\SendSubscribeEmail;
use App\Mail\SubscribesNotice;
use DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Mail;

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
