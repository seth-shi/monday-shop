<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Form;
use Illuminate\Database\Eloquent\Model;

class AdminUser extends Administrator
{
    public static function boot()
    {
        parent::boot();;
    
        self::saving(function () {
        
            if (app()->environment('dev')) {
    
               throw new \Exception('开发环境不允许操作');
            }
        });
    
    
        self::deleting(function () {
        
            if (app()->environment('dev')) {
            
                throw new \Exception('开发环境不允许操作');
            }
        });
    }
}
