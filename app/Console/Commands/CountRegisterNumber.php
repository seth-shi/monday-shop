<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CountRegisterNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'count:registered';

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
        file_put_contents(__DIR__.'/log.txt', time() . PHP_EOL, FILE_APPEND);
    }
}
