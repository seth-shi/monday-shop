<?php

namespace App\Models;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $fillable = ['product_id', 'link'];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
