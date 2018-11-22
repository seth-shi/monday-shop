<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteCount extends Model
{
    protected $fillable = [
        'date', 'registered_count', 'github_registered_count', 'qq_registered_count', 'weibo_registered_count',
        'product_sale_count', 'product_sale_money_count'
    ];
}
