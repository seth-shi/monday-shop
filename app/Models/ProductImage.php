<?php

namespace App\Models;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $fillable = ['product_id', 'link'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
