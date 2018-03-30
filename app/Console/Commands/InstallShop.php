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
        $this->call('key:generate');
        // 删除上一次保留的数据表
        $this->call('migrate:reset');
        // 删除上一次保留的文件
        $this->call('gps:delete');


        /****************************************
         * 1. 迁移数据表
         * 2. 数据库迁移
         * 3. 复制静态资源
         * 4. 创建软链接
         */
        $this->call('migrate');
        $this->call('db:seed');
        $this->call('gps:copy');
        $this->call('storage:link');

        // 直接开启监听队列
        $this->info('queue starting please don`t close cmd windows!!!');
        $this->call('queue:work', ['--tries' => '3']);
    }
}
