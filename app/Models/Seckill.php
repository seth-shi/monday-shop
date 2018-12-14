<?php

namespace App\Models;

use App\Jobs\RemindUsersHasSeckill;
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

    protected $fillable = ['id'];

    /**
     * 一个商品可以同时有多个商品同时秒杀，
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }


    public static function boot()
    {
        parent::boot();


        // 存入 redis
        static::created(function (Seckill $seckill) {

            // 从数据库中取出, 因为有一些默认值
            $seckill = Seckill::query()->find($seckill->id);
            $seckill->load('product');

            // 以后的数据都将从 redis 取出，直至秒杀结束
            \Redis::set($seckill->getRedisModelKey(), $seckill->toJson());
            // 填充一个 redis 队列，数量为抢购的数量，后面的 9 无意义
            // 当去队列的值时，只需要判断是否为 null，就可以得知还有没有数量
            $fill = array_fill(0, $seckill->numbers, 9);
            \Redis::lpush($seckill->getRedisQueueKey(), $fill);

            // 秒杀商品，如果用户收藏，发送邮件提醒活动
            RemindUsersHasSeckill::dispatch($seckill);
        });
    }


    /**
     * 获取所有的 redis key
     *
     * @return array
     */
    public function getAllRedisKey()
    {
        // 用户保存的 hset 需要匹配出来一个一个删
        return [$this->getRedisModelKey(), $this->getRedisQueueKey()];
    }

    /**
     * 存储抢到的用户
     *
     * @param $id
     * @return string
     */
    public function getUsersKey($id)
    {
        return "seckills:{$this->id}:users:{$id}";
    }

    /**
     * 存储模型 json 字符串
     *
     * @return string
     */
    public function getRedisModelKey()
    {
        return "seckills:{$this->id}:model";
    }

    /**
     * 存储一个 秒杀数量的队列
     *
     * @return string
     */
    public function getRedisQueueKey()
    {
        return "seckills:{$this->id}:queue";
    }
}
