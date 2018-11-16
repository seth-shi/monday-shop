<?php

namespace App\Console\Commands;

class ClearCache extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear moon:cache cache information';

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
     * 清除所有缓存
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
    }
}
