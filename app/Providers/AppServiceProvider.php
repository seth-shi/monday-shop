<?php

namespace App\Providers;

use Encore\Admin\AdminServiceProvider;
use Encore\Admin\Facades\Admin;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 如果在后台运行, 启动后台服务
        if (request()->is('admin*') || app()->runningInConsole()) {

            Schema::defaultStringLength(191);
            // 注册门面
            AliasLoader::getInstance()->alias('Admin', Admin::class);

            $this->app->register(AdminServiceProvider::class);
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
