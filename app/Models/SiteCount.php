<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteCount extends Model
{
    protected $fillable = [
        'date', 'register_count', 'github_register_count', 'qq_register_count', 'weibo_register_count',
        'product_sale_count', 'product_sale_money_count'
    ];
}
