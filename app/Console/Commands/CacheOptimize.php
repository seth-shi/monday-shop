<?php

namespace App\Console\Commands;


class CacheOptimize extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gps:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache routing, configure information, to speed up the website running speed';

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
        // Optimal configuration loading
        $this->call('config:cache');
        // Optimized routing loading
        $this->call('route:cache');
        /**
         * Optimizing class mapping loading
         * This command will run after > php artisan config:cache,
         * Because the optimize command generates files based on configuration information
         */
        $this->call('optimize', ['--force']);
    }
}
