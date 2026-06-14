<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    protected $table = 'admin_users';

    protected $fillable = ['username', 'name', 'avatar', 'login_ip'];

    protected $hidden = ['password', 'remember_token'];
}
