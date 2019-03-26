<?php

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Auth\Database\Permission;
use Encore\Admin\Auth\Database\Role;
use Illuminate\Database\Seeder;

class SettingsTablesSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            [
                'index_code' => 'user_init_password',
                'value' => '123456',
                'type' => 'text',
                'description' => '注册用户的初始密码'
            ],
            [
                'index_code' => 'is_open_seckill',
                'value' => 0,
                'type' => 'switch',
                'description' => '是否开始秒杀功能模块（需要配置好 redis）'
            ],
            [
                'index_code' => 'order_un_pay_auto_cancel_time',
                'value' => 30,
                'type' => 'number',
                'description' => '用户下订单之后，多久未付款自动取消订单。单位为分钟'
            ],
        ];

        $now = \Carbon\Carbon::now()->toDateTimeString();
        $settings = collect($settings)->map(function ($setting) use ($now) {

            $setting['created_at'] = $now;
            $setting['updated_at'] = $now;

            return $setting;
        });

        \App\Models\Setting::query()->insert($settings->all());
    }
}
