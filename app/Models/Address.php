<?php

namespace App\Models;

class Address extends Model
{
    protected $table = 'addresses';
    protected $fillable = ['name', 'phone', 'province_id', 'city_id', 'detail_address', 'is_default', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function format()
    {
        return optional($this->province)->name . optional($this->city)->name. $this->detail_address;
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
