<?php

namespace App\Mail;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribesNotice extends Mailable
{
    public $subject = '星期一商城订阅消息';
    public $unSubUrl;

    public function __construct($url)
    {
        $this->unSubUrl = $url;
    }


    public function build()
    {
        $latest = Product::query()->latest()->first();
        $hottest =  Product::query()->orderBy('sale_count', 'desc')->first();
        $likest = Product::query()->withCount('users')->orderBy('users_count', 'desc')->first();

        return $this->markdown('emails.subscribes', compact('likest', 'latest', 'hottest'));
    }
}
