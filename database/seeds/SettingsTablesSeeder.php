<?php

use App\Enums\SettingKeyEnum;
use App\Models\Setting;
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
            SettingKeyEnum::USER_INIT_PASSWORD => '123456',
            SettingKeyEnum::IS_OPEN_SECKILL => '0',
            SettingKeyEnum::UN_PAY_CANCEL_TIME => '30',
            SettingKeyEnum::POST_AMOUNT => '9.9',
        ];

        collect($settings)->map(function ($val, $key) {

           $setting = Setting::query()->firstOrNew(['key' => $key]);
           $setting->value = $val;
           $setting->save();
        });
    }
}
