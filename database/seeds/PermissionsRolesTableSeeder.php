<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // all permissions
        $admin = Role::where('name', '超级管理员')->first();
        $this->givePermission($admin, [
            '添加管理员', '修改管理员', '删除管理员',
            '添加分类', '修改分类', '删除分类',
            '添加商品', '修改商品', '删除商品',
            '添加用户', '修改用户', '删除用户',
        ]);

        $admin = Role::where('name', '管理员')->first();
        $this->givePermission($admin, [
            '添加分类', '修改分类', '删除分类',
            '添加商品', '修改商品', '删除商品',
            '添加用户', '修改用户', '删除用户',
        ]);

        $admin = Role::where('name', '分类管理员')->first();
        $this->givePermission($admin, [
            '添加分类', '修改分类', '删除分类',
        ]);

        $admin = Role::where('name', '商品管理员')->first();
        $this->givePermission($admin, [
            '添加商品', '修改商品', '删除商品',
        ]);

        $admin = Role::where('name', '用户管理员')->first();
        $this->givePermission($admin, [
            '添加用户', '修改用户', '删除用户',
        ]);
    }

    protected function givePermission($user, array $permissions)
    {
        foreach ($permissions as $permission) {
            $user->givePermissionTo($permission);
        }
    }
}
