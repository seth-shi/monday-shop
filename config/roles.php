<?php

// The default permissions and roles of the system
return [
    'role' => [
        'superAdmin' => ['name' => '超级管理员', 'guard_name' => 'admin'],
        'admin' =>['name' => '管理员', 'guard_name' => 'admin'],
        'category' =>['name' => '分类管理员', 'guard_name' => 'admin'],
        'product' =>['name' => '商品管理员', 'guard_name' => 'admin'],
        'user' => ['name' => '用户管理员', 'guard_name' => 'admin'],
    ],
    'permission' => [
        'admin' => [
            ['name' => '添加管理员', 'guard_name' => 'admin'],
            ['name' => '修改管理员', 'guard_name' => 'admin'],
            ['name' => '删除管理员', 'guard_name' => 'admin'],
        ],
        'category' => [
            ['name' => '添加分类', 'guard_name' => 'admin'],
            ['name' => '修改分类', 'guard_name' => 'admin'],
            ['name' => '删除分类', 'guard_name' => 'admin'],
        ],
        'product' => [
            ['name' => '添加商品', 'guard_name' => 'admin'],
            ['name' => '修改商品', 'guard_name' => 'admin'],
            ['name' => '删除商品', 'guard_name' => 'admin'],
        ],
        'user' => [
            ['name' => '添加用户', 'guard_name' => 'admin'],
            ['name' => '修改用户', 'guard_name' => 'admin'],
            ['name' => '删除用户', 'guard_name' => 'admin'],
        ]
    ]
];