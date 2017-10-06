<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    // 允许填充的字段
    protected $fillable = [
        'username',
        'password',
        'email',
        'nickname',
        'avatar',
        'status',
        'token',
        'access_token',
        'provider_name',
    ];

    // 隐藏的字段
    protected $hidden = ['password'];
}
