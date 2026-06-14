<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    public function run(): void
    {
        AdminUser::query()->firstOrCreate(
            ['username' => env('ADMIN_USERNAME', 'admin')],
            ['name' => 'Administrator', 'password' => bcrypt(env('ADMIN_PASSWORD', 'admin'))]
        );
    }
}
