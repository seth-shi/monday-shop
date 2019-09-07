<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Car
 *
 * @property int $id
 * @property int $number 商品的数量
 * @property int $product_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Car newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Car newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Car query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Car whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Car whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Car whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Car whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Car whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Car whereUserId($value)
 * @mixin \Eloquent
 */
class Car extends Model
{
    protected $table = 'cars';
    protected $fillable = ['number', 'user_id', 'product_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault(function () {

            $product = new Product();
            $product->name = '商品已下架';
            $product->thumb = get404Image();
            $product->price = 0;
        });
    }
}
