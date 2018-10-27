<?php

namespace App\Models;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $fillable = ['numbers', 'product_id', 'order_id', 'price', 'total'];

    public $timestamps = false;


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function comment()
    {
        return $this->hasOne(Comment::class);
    }
}
