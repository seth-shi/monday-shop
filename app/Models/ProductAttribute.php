<?php

namespace App\Models;


class ProductAttribute extends Model
{
    protected $table = 'product_attributes';
    protected $fillable = ['attribute', 'items', 'markup'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
