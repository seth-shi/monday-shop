<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Seckill
 *
 * @property int $id
 * @property int $product_id
 * @property int $numbers 秒杀的数量
 * @property int $safe_count 卖出的数量
 * @property string $start_at 抢购开始时间
 * @property string $end_at 抢购结束时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seckill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seckill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seckill query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seckill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seckill whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seckill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seckill whereNumbers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seckill whereSafeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seckill whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seckill whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seckill whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Seckill extends Model
{
    protected $casts = [
        'price' => 'double'
    ];
    /**
     * 一个商品可以同时有多个商品同时秒杀，
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
