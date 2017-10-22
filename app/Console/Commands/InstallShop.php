<?php

namespace App\Console\Commands;


class InstallShop extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gps:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Project Initialize Command';

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
        $this->execShellWithPrint('php artisan key:generate');
        $this->execShellWithPrint('php artisan migrate');
        $this->execShellWithPrint('php artisan db:seed');
        // Join queue of failed teams after three failed monitoring queues
        $this->execShellWithPrint('php artisan queue:work --tries=3');
    }
}
