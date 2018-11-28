<?php

namespace App\Admin\Transforms;


use App\Models\Order;

class OrderDetailTransform extends Transform
{

    public function transCommented($isCommented)
    {
        return $isCommented ? '<span class="glyphicon glyphicon-ok bg-green"></span>' : '';
    }
}
