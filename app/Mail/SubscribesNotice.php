<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class SubscribesNotice extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = '星期一商城订阅消息';


    public function __construct()
    {
        //
    }


    public function build()
    {

        $latest = Cache::remember('subscribes:latest', 1, function () {

            return Product::query()->latest()->first();
        });
        $hottest =  Cache::remember('subscribes:latest', 1, function () {

            return Product::query()->orderBy('safe_count', 'desc')->first();
        });
        $likest = Cache::remember('subscribes:latest', 1, function () {

            return Product::query()->withCount('users')->orderBy('users_count', 'desc')->first();
        });

        return $this->markdown('emails.subscribes', compact('likest', 'latest', 'hottest'));
    }
}
