<?php

namespace App\Models;

class Subscribe extends Model
{
    protected $table = 'subscribes';
    protected $fillable = ['email', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
