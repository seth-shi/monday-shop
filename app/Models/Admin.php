<?php

namespace App\Models;

class Admin extends Model
{
    protected $table = 'admins';
    protected $fillable = ['name', 'password', 'email', 'avatar', 'last_ip'];
}
