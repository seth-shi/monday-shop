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
        // 重新生成密钥
        $this->execShellWithPrint('php artisan key:generate');
        // 数据库迁移
        $this->execShellWithPrint('php artisan migrate');
        // 数据库填充
        $this->execShellWithPrint('php artisan db:seed');
        // 监听队列 TODO 这里需要常驻运行监听
        $this->execShellWithPrint('php artisan queue:work');
    }
}
