<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductDetail
 *
 * @property int $id
 * @property string $content 商品的描述
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductDetail whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductDetail extends Model
{
    protected $table = 'product_details';
    protected $fillable = ['count', 'unit', 'description', 'product_id'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
