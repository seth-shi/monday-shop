<?php

namespace App\Models;

class ProductDetail extends Model
{
    protected $table = 'product_details';
    protected $fillable = ['count', 'unit', 'description', 'product_id'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
