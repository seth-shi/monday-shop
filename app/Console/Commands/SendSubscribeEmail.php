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
    protected $signature = 'send:subscribes';

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
        Subscribe::query()
                 ->get()
                 ->each(function(Subscribe $item){
                     Mail::to($item->email)->queue(new SubscribesNotice());
                 });
    }
}
