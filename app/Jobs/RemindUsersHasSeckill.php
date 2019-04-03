<?php

namespace App\Jobs;

use App\Mail\RemindUserHasSeckillEmail;
use App\Models\Product;
use App\Models\Seckill;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class RemindUsersHasSeckill implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $seckill;

    /**
     * Create a new job instance.
     *
     * @param Seckill $seckill
     */
    public function __construct(Seckill $seckill)
    {
        $this->seckill = $seckill;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /**
         * @var $product Product
         */
        // 拿出收藏的用户
        $product = $this->seckill->product;

        $product->users()
                ->get()
                ->map(function (User $user) use ($product) {

                    Mail::to($user->email)->send(new RemindUserHasSeckillEmail($this->seckill, $product));
                });


    }
}
