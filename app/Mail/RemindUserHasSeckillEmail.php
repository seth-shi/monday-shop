<?php

namespace App\Mail;

use App\Models\Product;
use App\Models\Seckill;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemindUserHasSeckillEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $seckill;
    public $product;

    /**
     * Create a new message instance.
     *
     * @param Product $product
     */
    public function __construct(Seckill $seckill, Product $product)
    {
        $this->product = $product;
        $this->seckill = $seckill;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.seckills');
    }
}
