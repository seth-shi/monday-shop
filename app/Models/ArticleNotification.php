<?php

namespace App\Models;

use App\Notifications\ArticleTitleNotification;
use App\Notifications\CouponCodeNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use Ramsey\Uuid\Uuid;

class ArticleNotification extends Model
{
    //

    public static function boot()
    {
        parent::boot();


        self::created(function (ArticleNotification $article) {

            // 创建消息发布给所有人
            $users = User::query()->get();

            $now = Carbon::now();
            $notifications = $users->map(function (User $user) use ($now, $article) {

                $notification = [
                    'id' => Uuid::uuid4()->toString(),
                    'type' => ArticleTitleNotification::class,
                    'notifiable_id' => $user->id,
                    'notifiable_type' => get_class($user),
                    'data' => json_encode((new ArticleTitleNotification($article))->toArray($user), JSON_UNESCAPED_UNICODE),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                return $notification;
            });

            $size = 1000;
            foreach (array_chunk($notifications->all(), $size, true) as $chunk) {
                // 通知
                DatabaseNotification::query()->insert($chunk);
            }
        });
    }
}
