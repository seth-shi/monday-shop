<?php

namespace App\Admin\Transforms;


class ProductTransform extends Transform
{
    public function transDeleted($isAlive)
    {
        return is_null($isAlive) ? '<mark>上架</mark>' : '<mark style="color: red">下架</mark>';
    }
}
