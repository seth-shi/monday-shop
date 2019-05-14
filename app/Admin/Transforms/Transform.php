<?php

namespace App\Admin\Transforms;


class Transform
{
    protected static $instance;

    /**
     * @return static
     */
    public static function getInstance()
    {
        $class = static::class;

        if (! isset(static::$instance[$class])) {
            static::$instance[$class] = new static();
        }


        return static::$instance[$class];
    }
}
