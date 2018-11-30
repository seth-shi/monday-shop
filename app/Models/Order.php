<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use phpDocumentor\Reflection\Types\Self_;

class Order extends Model
{

    use SoftDeletes;

    protected $table = 'orders';
    protected $fillable = ['uuid', 'total', 'status', 'consignee_name', 'consignee_phone', 'consignee_address', 'user_id'];


    // 订单状态
    const PAY_STATUSES = [
        // 退款
        'REFUND' => -1,
        // 未支付
        'UN_PAY' => 0,
        // 阿里支付，微信支付
        'ALI' => 1,
        'WEIXIN' => 2
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
            if ($model->status == self::PAY_STATUSES['ALI']) {
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
            elseif ($model->status == self::PAY_STATUSES['REFUND']) {

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

            if (! self::query()->where('no', $no)->exists()) {
                return $no;
            }
        }

        throw new \Exception('流水号生成失败');
    }
}
