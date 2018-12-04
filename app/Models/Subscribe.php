<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $table = 'subscribes';
    protected $fillable = ['email', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
