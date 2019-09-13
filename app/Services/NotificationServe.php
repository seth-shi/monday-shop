<?php

namespace App\Services;

use App\Notifications\CouponCodeNotification;
use Illuminate\Notifications\DatabaseNotification;

class NotificationServe
{
   public static function getTitle(DatabaseNotification $notification)
   {
       $data = $notification->data;

       if (isset($data['title'])) {

           return $data['title'];
       }

       $title = '';
       switch ($notification->type) {

           case CouponCodeNotification::class:
               $title = "你获得了新的优惠券兑换码，火速前往";
               break;
           default:
               $title = '默认消息';
               break;
       }

       return $title;
   }
}
