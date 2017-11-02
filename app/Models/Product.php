<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['category_id', 'name', 'price', 'price_original', 'thumb', 'uuid'];


    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }


    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function productAttribute()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
