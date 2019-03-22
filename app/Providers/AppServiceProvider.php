<?php

namespace App\Providers;

use Encore\Admin\AdminServiceProvider;
use Encore\Admin\Backup\BackupServiceProvider as AdminBackupServiceProvider;
use Encore\Admin\Facades\Admin;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Backup\BackupServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // 如果在后台运行, 启动后台服务
        if (request()->is('admin*') || app()->runningInConsole()) {

            // 注册门面
            AliasLoader::getInstance()->alias('Admin', Admin::class);

            $this->app->register(AdminServiceProvider::class);
            $this->app->register(BackupServiceProvider::class);
            $this->app->register(AdminBackupServiceProvider::class);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
