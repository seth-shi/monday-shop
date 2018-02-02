<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $table = 'admins';
    protected $fillable = ['name', 'password', 'email', 'avatar', 'last_ip'];

    protected $guard_name = 'admin';
}
