<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SiteCount
 *
 * @property int $id
 * @property string $date
 * @property int $registered_count
 * @property int $github_registered_count
 * @property int $weibo_registered_count
 * @property int $qq_registered_count
 * @property int $moon_registered_count 通过商城前台注册
 * @property int $order_count 订单量
 * @property int $order_pay_count 有效的订单成交量，已支付的
 * @property int $refund_pay_count 取消的订单量
 * @property float $sale_money_count 商城金钱销售的数量
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount whereGithubRegisteredCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount whereMoonRegisteredCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount whereOrderPayCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount whereQqRegisteredCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount whereRefundPayCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount whereRegisteredCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount whereSaleMoneyCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SiteCount whereWeiboRegisteredCount($value)
 * @mixin \Eloquent
 */
class SiteCount extends Model
{
    protected $fillable = ['date'];
}
