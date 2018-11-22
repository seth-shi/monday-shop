<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $fillable = ['numbers', 'product_id', 'order_id', 'price', 'total'];

    public $timestamps = false;


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function comment()
    {
        return $this->hasOne(Comment::class);
    }


    public static function boot()
    {
        parent::boot();



        static::created(function ($model) {

            // 有过有取消订单功能，记得减去数量
            Cache::increment("site_counts:product_sale_number_count", $model->numbers);
        });
    }
}
