<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\CouponCodeNotification;
use App\Services\NotificationServe;
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

            $notification->title = NotificationServe::getTitle($notification);
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
        // 标记为已读
        $notification->markAsRead();

        $view = NotificationServe::getView($notification);
        if (! view()->exists($view)) {

            abort(404, '未知的的消息');
        }

        $notification->title = NotificationServe::getTitle($notification);
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


        $title = '';
        $content = '';
        $id = null;
        if ($count > 0) {

            $notification = $user->unreadNotifications()->first();

            // 前端弹窗内容和标题相反显示，所以变量名会有点怪
            $id = $notification->id;
            $title = NotificationServe::getContent($notification);
            $content = NotificationServe::getTitle($notification);
        }

        return responseJson(200, 'success', compact('count', 'title', 'content', 'id'));
    }
}
