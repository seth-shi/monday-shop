<?php

namespace App\Admin\Transforms;


use App\Enums\UserStatusEnum;

class YesNoTransform implements Transform
{
    public static function trans($is)
    {
        return $is
            ? "<i style='color: green;' class=\"fa fa-check-circle\" aria-hidden=\"true\"></i>"
            : "<i style='color: red;' class=\"fa fa-times\" aria-hidden=\"true\"></i>";
    }
}
