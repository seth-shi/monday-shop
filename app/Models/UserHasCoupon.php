<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserHasCoupon
 *
 * @property int $id
 * @property int $user_id
 * @property int $template_id
 * @property string $title 优惠券标题
 * @property float $amount 满减金额
 * @property float $full_amount 门槛金额
 * @property string $start_date 开始日期
 * @property string $end_date 结束日期
 * @property string|null $used_at 使用时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasCoupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasCoupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasCoupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasCoupon whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasCoupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasCoupon whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasCoupon whereFullAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasCoupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasCoupon whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasCoupon whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasCoupon whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasCoupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasCoupon whereUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasCoupon whereUserId($value)
 * @mixin \Eloquent
 */
class UserHasCoupon extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
