<?php

namespace App\Console\Commands;

class ClearCache extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gps:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear gps:cache cache information';

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
        /**
         * Corresponding App\Console\Commands\CacheOptimize file
         */
        $this->execShellWithPrint('php artisan config:clear');
        $this->execShellWithPrint('php artisan route:clear');
        $this->execShellWithPrint('php artisan clear-compiled');
    }
}
