<?php

namespace App\Mail;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
        $latest = Product::query()->latest()->first();
        $hottest =  Product::query()->orderBy('sale_count', 'desc')->first();
        $likest = Product::query()->withCount('users')->orderBy('users_count', 'desc')->first();

        return $this->markdown('emails.subscribes', compact('likest', 'latest', 'hottest'));
    }
}
