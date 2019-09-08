<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Enums\SiteCountCacheEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;




/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $no 订单流水号
 * @property int $user_id
 * @property float $amount 总计价格
 * @property int $status
 * @property string|null $pay_type 支付类型
 * @property string|null $refund_reason 退款理由
 * @property int $ship_status 物流状况
 * @property string|null $express_company 快递公司
 * @property string|null $express_no 快递单号
 * @property int $type 订单类型,1普通订单，2秒杀订单
 * @property string|null $name 订单的名字，用于第三方，只有一个商品就是商品的名字，多个商品取联合
 * @property string|null $consignee_name 收货人
 * @property string|null $consignee_phone 收货人手机号码
 * @property string|null $consignee_address 收货地址
 * @property string|null $pay_no 第三方支付单号
 * @property float|null $pay_amount 实际支付金额
 * @property string|null $paid_at 支付时间
 * @property float|null $pay_refund_fee 退款金额
 * @property string|null $pay_trade_no 第三方退款订单号
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float|null $coupon_amount 优惠价格
 * @property float|null $post_amount 邮费
 * @property float|null $origin_amount 订单原价
 * @property int|null $coupon_id
 * @property-read \App\Models\Address $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderDetail[] $details
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereConsigneeAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereConsigneeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereConsigneePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCouponAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereExpressCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereExpressNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereOriginAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePayAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePayNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePayRefundFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePayTradeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePostAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereRefundReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereShipStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withoutTrashed()
 * @mixin \Eloquent
 */
class Order extends Model
{

    use SoftDeletes;

    protected $table = 'orders';
    protected $fillable = [
        'uuid', 'amount', 'status', 'type',
        'consignee_name', 'consignee_phone', 'consignee_address', 'user_id'
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isNotUser($id)
    {
        return $this->user_id != $id;
    }

    public static function boot()
    {
        parent::boot();


        // 自动生成订单的订单号
        static::creating(function ($model) {

            if (is_null($model->no)) {
                $model->no = static::findAvailableNo($model->user_id);
            }
        });

        static::created(function ($model) {

            // 订单成交量
            Cache::increment(SiteCountCacheEnum::ORDER_COUNT);
        });

        static::saved(function ($model) {

            // 支付
            if ($model->status == OrderStatusEnum::PAID) {
                // 订单成交量
                Cache::increment(SiteCountCacheEnum::PAY_ORDER_COUNT);

                $currMoney = Cache::get(SiteCountCacheEnum::SALE_ORDER_COUNT, 0);
                if (function_exists('bcadd')) {
                    $money = bcadd($currMoney, $model->pay_amount);
                } else {
                    $money = $currMoney + $model->pay_amount;
                }

                Cache::set(SiteCountCacheEnum::SALE_ORDER_COUNT, $money);
            }
            // 退款
            elseif ($model->status == OrderStatusEnum::REFUND) {

                $currMoney = Cache::get(SiteCountCacheEnum::SALE_ORDER_COUNT, 0);
                if (function_exists('bcsub')) {
                    $money = bcsub($currMoney, $model->pay_refund_fee);
                } else {
                    $money = $currMoney - $model->pay_refund_fee;
                }

                Cache::increment(SiteCountCacheEnum::REFUND_ORDER_COUNT);
                Cache::set(SiteCountCacheEnum::SALE_ORDER_COUNT, $money);
            }

        });
    }

    /**
     * @param string $userId
     * @param int    $try
     * @return string
     * @throws \Exception
     */
    public static function findAvailableNo($userId = '000000000', $try = 5)
    {
        $prefix = date('YmdHis');
        $suffix = fixStrLength($userId, 9);

        for ($i = 0; $i < $try; ++ $i) {
            $no = $prefix . fixStrLength(random_int(0, 9999), 5) . $suffix;

            if (self::query()->where('no', $no)->doesntExist()) {
                return $no;
            }
        }

        throw new \Exception('流水号生成失败');
    }
}
