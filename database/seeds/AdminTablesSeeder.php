<?php

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Auth\Database\Permission;
use Encore\Admin\Auth\Database\Role;
use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    public function run()
    {
        // create a user.
        Administrator::truncate();
        Administrator::create([
                                  'username' => 'admin',
                                  'password' => bcrypt('admin'),
                                  'name'     => 'Administrator',
                              ]);

        // create a role.
        Role::truncate();
        Role::create([
                         'name' => 'Administrator',
                         'slug' => 'administrator',
                     ]);

        // add role to user.
        Administrator::first()->roles()->save(Role::first());

        //create a permission
        Permission::truncate();
        Permission::insert([
                               [
                                   'name'        => 'All permission',
                                   'slug'        => '*',
                                   'http_method' => '',
                                   'http_path'   => '*',
                               ],
                               [
                                   'name'        => 'Dashboard',
                                   'slug'        => 'dashboard',
                                   'http_method' => 'GET',
                                   'http_path'   => '/',
                               ],
                               [
                                   'name'        => 'Login',
                                   'slug'        => 'auth.login',
                                   'http_method' => '',
                                   'http_path'   => "/auth/login\r\n/auth/logout",
                               ],
                               [
                                   'name'        => 'User setting',
                                   'slug'        => 'auth.setting',
                                   'http_method' => 'GET,PUT',
                                   'http_path'   => '/auth/setting',
                               ],
                               [
                                   'name'        => 'Auth management',
                                   'slug'        => 'auth.management',
                                   'http_method' => '',
                                   'http_path'   => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs",
                               ],
                           ]);

        $role = Role::first();
        $role->permissions()->save(Permission::first());

        // add default menus.
        Menu::truncate();
        $menusJson = json_decode(file_get_contents(__DIR__.'/../data/menus.json'), true);
        Menu::insert($menusJson);

        // add role to menu.
        Menu::query()
            ->where('parent_id', 0)
            ->where('id', '!=', 1)
            ->get()
            ->map(function (Menu $menu) use ($role) {
                $menu->roles()->save($role);
            });
    }
}
