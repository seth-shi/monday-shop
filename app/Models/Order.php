<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $no 订单流水号
 * @property int $user_id
 * @property float $total 总计价格
 * @property int $status -1：退款， 0：未支付订单，1:支付宝支付，
 * @property string|null $name 订单的名字，用于第三方，只有一个商品就是商品的名字，多个商品取联合
 * @property string|null $consignee_name 收货人
 * @property string|null $consignee_phone 收货人手机号码
 * @property string|null $consignee_address 收货地址
 * @property string|null $pay_no 第三方支付单号
 * @property float|null $pay_total 实际支付金额
 * @property string|null $pay_time 支付时间
 * @property float|null $pay_refund_fee 退款金额
 * @property string|null $pay_trade_no 第三方退款订单号
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderDetail[] $details
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereConsigneeAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereConsigneeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereConsigneePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePayNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePayRefundFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePayTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePayTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePayTradeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereTotal($value)
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
        'uuid', 'total', 'status', 'type',
        'consignee_name', 'consignee_phone', 'consignee_address', 'user_id'
    ];


    // 订单类型
    const TYPES = [
        'COMMON' => 1,
        'SEC_KILL' => 2
    ];

    // 订单状态
    const STATUSES = [
        // 退款
        'REFUND' => -1,
        // 未支付
        'UN_PAY' => 0,
        // 阿里支付，微信支付
        'ALI' => 1,
        'WEIXIN' => 2,
        // 超时系统取消订单
        'UN_PAY_CANCEL' => 3,
        // 订单完成, 完成之后的订单不允许退款
        'COMPLETE' => 4,
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
            Cache::increment("site_counts:order_count");
        });

        static::saved(function ($model) {

            // 支付
            if ($model->status == self::STATUSES['ALI']) {
                // 订单成交量
                Cache::increment("site_counts:order_pay_count");

                $currMoney = Cache::get('site_counts:sale_money_count', 0);
                if (function_exists('bcadd')) {
                    $money = bcadd($currMoney, $model->pay_total);
                } else {
                    $money = $currMoney + $model->pay_total;
                }

                Cache::set("site_counts:sale_money_count", $money);
            }
            // 退款
            elseif ($model->status == self::STATUSES['REFUND']) {

                $currMoney = Cache::get('site_counts:sale_money_count', 0);
                if (function_exists('bcsub')) {
                    $money = bcsub($currMoney, $model->pay_refund_fee);
                } else {
                    $money = $currMoney - $model->pay_refund_fee;
                }

                Cache::increment('site_counts:refund_pay_count');
                Cache::set("site_counts:sale_money_count", $money);
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
