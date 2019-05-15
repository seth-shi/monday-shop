<?php

namespace App\Console\Commands;

use App\Mail\SubscribesNotice;
use App\Models\Subscribe;
use Illuminate\Console\Command;
use Mail;

class SendSubscribeEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:send-subscribes';

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
        $mails = Subscribe::query()->where('is_subscribe', 1)->pluck('email');

        $mails->map(function ($realMail) {

            $email = encrypt($realMail);
            $url = route('site.email', compact('email'));
            // 不要一次 to 多个用户，会暴露其他人的邮箱
            Mail::to($realMail)->send(new SubscribesNotice($url));
        });

        createSystemLog('系统发送订阅消息, 发送的用户:' . $mails->implode(', '), $mails->toArray());
    }
}
