<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\CouponCodeNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        /**
         * @var $user User
         */
        $user = auth()->user();


        switch ($request->input('tab', 1)) {

            case 2:
                $query = $user->notifications();
                break;
            case 3:
                $query = $user->readNotifications();
                break;
            case 1:
            default:
                $query = $user->unreadNotifications();
                break;
        }

        $notifications = $query->paginate();

        foreach ($notifications as $notification) {

            switch ($notification->type) {

                case CouponCodeNotification::class:
                    $notification->is_code = true;
                    break;
                default:
                    $notification->is_default = 0;
                    break;
            }
        }

        $unreadCount = $user->unreadNotifications()->count();
        $readCount = $user->readNotifications()->count();

        return view('user.notifications.index', compact('notifications', 'unreadCount', 'readCount'));
    }

    public function read($id)
    {
        /**
         * @var $user User
         */
        $user = auth()->user();

        /**
         * @var $notification DatabaseNotification
         */
        $notification = $user->notifications()->find($id);
        if (is_null($notification)) {

            return responseJsonAsBadRequest('无效的通知');
        }

        $notification->markAsRead();

        return responseJson();
    }

    public function readAll()
    {
        /**
         * @var $user User
         */
        $user = auth()->user();


        $count = $user->unreadNotifications()->update(['read_at' => Carbon::now()]);


        return responseJson(200, "本次已读{$count}条消息");
    }

    public function show($id)
    {

        /**
         * @var $user User
         */
        $user = auth()->user();

        /**
         * @var $notification DatabaseNotification
         */
        $notification = $user->notifications()->find($id);
        if (is_null($notification)) {

            return abort(403, '无效的通知');
        }

        // 查看是否有上一条下一条
        $last = $user->notifications()->where('created_at', '<', $notification->created_at)->first();
        $next = $user->notifications()->where('created_at', '>', $notification->created_at)->first();

        $notification->markAsRead();

        // 使用哪一个模板
        $view = 'default';
        switch ($notification->type) {

            case CouponCodeNotification::class:
                $view = 'code';
                break;
        }
        $view = "user.notifications.types.{$view}";

        if (! view()->exists($view)) {

            abort(404, '未知的的消息');
        }

        $data = $notification->data;

        return view('user.notifications.show', compact('last', 'next', 'notification', 'view', 'data'));
    }


    public function getUnreadCount()
    {
        /**
         * @var $user User
         */
        $user = auth()->user();

        /**
         * @var $notification DatabaseNotification
         */
        $count = $user->unreadNotifications()->count();

        return responseJson(200, 'success', compact('count'));
    }
}
