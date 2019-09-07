<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CouponTemplate
 *
 * @property int $id
 * @property string $title 优惠券标题
 * @property float $amount 满减金额
 * @property float $full_amount 门槛金额
 * @property int $score 使用多少积分兑换优惠券
 * @property string $start_date 开始日期
 * @property string $end_date 结束日期
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTemplate whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTemplate whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTemplate whereFullAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTemplate whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTemplate whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTemplate whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTemplate whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserHasCoupon[] $coupons
 */
class CouponTemplate extends Model
{
    public function coupons()
    {
        return $this->hasMany(UserHasCoupon::class, 'template_id');
    }

    public function getAmountAttribute($value)
    {
        if ($value == intval($value)) {

            $value = intval($value);
        }

        return $value;
    }

    public function getFullAmountAttribute($value)
    {
        if ($value == intval($value)) {

            $value = intval($value);
        }

        return $value;
    }
}
