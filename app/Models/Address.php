<?php

namespace App\Models;

class Address extends Model
{
    protected $table = 'addresses';
    protected $fillable = ['name', 'phone', 'province', 'city', 'region', 'detail_address', 'is_default', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
