<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $fillable = ['numbers', 'product_id', 'order_id'];

    public $timestamps = false;


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
