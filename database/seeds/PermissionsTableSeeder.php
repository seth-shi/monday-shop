<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = config('roles.permission');

        foreach ($permissions as $value) {
            foreach ($value as $v) {
                Permission::create($v);
            }
        }
    }
}
