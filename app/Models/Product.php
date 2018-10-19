<?php

namespace App\Models;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'price', 'price_original',
        'pinyin', 'first_pinyin', 'thumb', 'uuid', 'title', 'pictures'];

    protected $casts = [
        'pictures' => 'json'
    ];



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

    public function detail()
    {
        return $this->hasOne(ProductDetail::class);
    }


    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }


    public function orderDetail()
    {
        return $this->hasOne(orderDetail::class);
    }

    public static function boot()
    {
        parent::boot();
//
//        $form->text('pinyin', 'Pinyin');
//        $form->text('first_pinyin', 'First pinyin');
        // TODO 拼音
        // 把分类的
        static::saving(function () {

        });
    }
}
