<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductHasUser
 *
 * @property int $user_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductHasUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductHasUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductHasUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductHasUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductHasUser whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductHasUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductHasUser whereUserId($value)
 * @mixin \Eloquent
 */
class ProductHasUser extends Model
{
    protected $table = 'likes_products';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
