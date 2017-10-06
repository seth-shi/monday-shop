<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 生成 50 条用户数据
        factory(\App\Models\User::class, 50)->create();
    }
}
