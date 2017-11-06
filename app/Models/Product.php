<?php

namespace App\Models;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['category_id', 'name', 'price', 'pinyin', 'first_pinyin', 'price_original', 'thumb', 'uuid', 'title'];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }


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
