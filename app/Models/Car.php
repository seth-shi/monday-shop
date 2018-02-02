<?php

namespace App\Models;

class Car extends Model
{
    protected $table = 'cars';
    protected $fillable = ['numbers', 'user_id', 'product_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
