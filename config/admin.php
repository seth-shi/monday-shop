<?php

return [
    'database' => [
        'connection' => env('DB_CONNECTION'),
        'users_table' => 'admin_users',
        'roles_table' => 'admin_roles',
        'permissions_table' => 'admin_permissions',
        'menu_table' => 'admin_menu',
        'operation_log_table' => 'admin_operation_log',
        'user_permissions_table' => 'admin_user_permissions',
        'role_users_table' => 'admin_role_users',
        'role_permissions_table' => 'admin_role_permissions',
        'role_menu_table' => 'admin_role_menu',
    ],
];
