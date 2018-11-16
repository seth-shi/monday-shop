<?php

namespace App\Console\Commands;


class CacheOptimize extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:cache';

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
     * 执行缓存命令
     *
     * @return mixed
     */
    public function handle()
    {
        // 优化配置
        $this->call('config:cache');
        // 优化路由
        $this->call('route:cache');
    }
}
