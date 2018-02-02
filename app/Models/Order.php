<?php

namespace App\Models;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['uuid', 'total', 'status', 'address_id', 'user_id'];


    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
