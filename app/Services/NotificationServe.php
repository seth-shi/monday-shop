<?php

namespace App\Services;

use App\Notifications\ArticleTitleNotification;
use App\Notifications\CouponCodeNotification;
use Illuminate\Notifications\DatabaseNotification;

class NotificationServe
{
    public static function getView(DatabaseNotification $notification)
    {
        // 使用哪一个模板
        $view = 'default';
        switch ($notification->type) {

            case CouponCodeNotification::class:
                $view = 'code';
                break;
            case ArticleTitleNotification::class:
                $view = 'article';
                break;
        }
        $view = "user.notifications.types.{$view}";

        return $view;
    }

   public static function getTitle(DatabaseNotification $notification)
   {
       $data = $notification->data;

       if (isset($data['title'])) {

           return $data['title'];
       }

       return self::getContent($notification);
   }

   public static function getContent(DatabaseNotification $notification)
   {
       $title = '';
       switch ($notification->type) {

           case CouponCodeNotification::class:
               $title = "你获得了新的优惠券兑换码，火速前往";
               break;
           case ArticleTitleNotification::class:
               $title = "有新的文章发布了，火速查看";
               break;
           default:
               $title = '默认消息';
               break;
       }

       return $title;
   }
}
