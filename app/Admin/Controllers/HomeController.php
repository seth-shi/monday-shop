<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Model;
use App\Models\SiteCount;
use App\Services\SiteCountService;
use Carbon\Carbon;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Content $content, SiteCountService $service)
    {
        // $users =

        return $content
            ->header('数据统计')
            ->row(function (Row $row) use ($service) {

                /**
                 *
                 * 今天的使用 cache
                 *
                 * @var $today SiteCount
                 */
                $carbon = Carbon::now();
                $today = SiteCount::query()->firstOrNew(['date' => $carbon->toDateString()]);
                $today = $service->syncByCache($today);


                $row->column(6, new Box('今日用户注册来源', view('admin.chars.today_register', compact('today'))));
                $row->column(6, new Box('今日成交量', view('admin.chars.today_sale', compact('today'))));
                //$row->column(4, new Box('Bar chart', view('admin.chart')));

            });
    }


}
