<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AdminsRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::where('name', 'admin')->first()->assignRole(\Spatie\Permission\Models\Role::all());
    }
}
