<?php

namespace App\Models;

use App\Mail\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active_token', 'is_active', 'avatar',
        'github_id', 'github_name', 'qq_id', 'qq_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * rewrite send reset password email
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        Mail::to($this->email)
            ->queue(new ResetPassword($token));
    }
}
