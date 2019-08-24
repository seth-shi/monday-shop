<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
