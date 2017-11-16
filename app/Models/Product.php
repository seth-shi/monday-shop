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

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'likes_products');
    }

    public function productDetail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }


    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }


    public function orderDetail()
    {
        return $this->hasOne(orderDetail::class);
    }
}
