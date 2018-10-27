<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'price', 'price_original',
        'pinyin', 'first_pinyin', 'thumb', 'uuid', 'title', 'pictures'];

    protected $casts = [
        'pictures' => 'json',
    ];



    public function getThumbAttribute($thumb)
    {
        return imageUrl($thumb);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

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


    public function orderDetail()
    {
        return $this->hasOne(orderDetail::class);
    }

    /**
     * 使用 uuid 注入
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public static function boot()
    {
        parent::boot();


        // 自动生成商品的 uuid， 拼音
        static::saving(function ($model) {

            if (is_null($model->uuid)) {
                $model->uuid = Uuid::generate()->hex;
            }

            if (is_null($model->pinyin)) {
                $model->pinyin = pinyin_permalink($model->name);
                $model->first_pinyin = substr($model->pinyin, 0, 1);
            }

            // 建立拼音表
            ProductPinYin::query()->firstOrCreate(['pinyin' => $model->first_pinyin]);
        });

        static::deleted(function ($model) {

            // 没有这个拼音了，删去
            if (! Product::query()->where('first_pinyin', $model->first_pinyin)->exists()) {
                ProductPinYin::query()->where('pinyin', $model->first_pinyin)->delete();
            }
        });
    }
}
