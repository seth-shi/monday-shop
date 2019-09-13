<?php

namespace App\Providers;

use Encore\Admin\AdminServiceProvider;
use Encore\Admin\Facades\Admin;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Providers\LaravelServiceProvider;
use Yxx\Kindeditor\EditorProvider;

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
        if (request()->is('admin*')) {

            $this->registerEditorService();
            $this->registerAdminService();
        } elseif (request()->is('yxx*')) {

            $this->registerEditorService();
        } elseif (request()->is('api*')) {

            config(['auth.defaults.guard' => 'api']);
            $this->registerJwtService();
        } elseif ($this->app->runningInConsole()) {

            Schema::defaultStringLength(191);
            $this->registerJwtService();
            $this->registerAdminService();
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

    protected function registerAdminService()
    {
        AliasLoader::getInstance()->alias('Admin', Admin::class);
        $this->app->register(AdminServiceProvider::class);
    }

    public function registerEditorService()
    {
        $this->app->register(EditorProvider::class);
    }

    protected function registerJwtService()
    {
        $this->app->register(LaravelServiceProvider::class);
    }
}
