<?php

namespace App\Console\Commands;


class UninstallShop extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gps:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Project Uninitialize Command';

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
        $this->call('gps:clear');
        $this->call('migrate:reset');

        // delete all upload static resources
        $this->call('gps:delete');
    }
}
