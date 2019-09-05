<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponTemplate extends Model
{
    public function getAmountAttribute($value)
    {
        if ($value == intval($value)) {

            $value = intval($value);
        }

        return $value;
    }

    public function getFullAmountAttribute($value)
    {
        if ($value == intval($value)) {

            $value = intval($value);
        }

        return $value;
    }
}
