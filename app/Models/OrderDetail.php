<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\OrderDetail
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $number 数量
 * @property float $price 商品单价
 * @property float $total 价格小计算
 * @property int $is_commented 订单是否评论过
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Comment $comment
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereIsCommented($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail wherenumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereNumber($value)
 */
class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $fillable = ['number', 'product_id', 'order_id', 'price', 'total'];

    public $timestamps = false;


    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault([
            'name' => '商品已下架',
            'thumb' => assertUrl('products/404.jpg')
        ]);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function comment()
    {
        return $this->hasOne(Comment::class);
    }
}
