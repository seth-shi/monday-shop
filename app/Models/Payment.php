<?php

namespace App\Models;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = ['price', 'istype', 'orderid', 'orderuid', 'goodsname'];
}
