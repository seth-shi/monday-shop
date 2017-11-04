<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = config('roles.role');
        $roles = array_values($roles);

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
