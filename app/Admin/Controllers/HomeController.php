<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SiteCount;
use App\Services\SiteCountService;
use Carbon\Carbon;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;

class HomeController extends Controller
{
    public function index(Content $content, SiteCountService $service)
    {
        // 使用 echart
        Admin::js('/js/echarts.min.js');

        return $content
            ->header('仪表盘')
            ->row(function (Row $row) use ($service) {

                /**
                 * 今日统计,今天的特殊，需要从缓存 redis 中读取
                 *
                 * @var $todaySite SiteCount
                 */
                $now = Carbon::now();
                $today = $now->toDateString();
                $todaySite = SiteCount::query()->firstOrNew(['date' => $today]);
                $todaySite = $service->syncByCache($todaySite);

                // 七日统计
                $lastWeekDate = $now->subDay(7);
                $weekSites = SiteCount::query()
                                      ->where('date', '!=', $today)
                                      ->where('date', '>', $lastWeekDate)
                                      ->get()
                                      ->push($todaySite);


                // 本月统计
                $month = $now->format('Y-m');
                $monthSites = SiteCount::query()
                                       ->where('date', '!=', $today)
                                       ->where('date', '>', $month)
                                       ->get()
                                       ->push($todaySite);


                // TODO 自适应，更好。
                $row->column(4, new Box('今日用户注册来源', view('admin.chars.today_register', compact('todaySite'))));
                $row->column(4, new Box('七日用户注册来源', view('admin.chars.week_register', compact('weekSites'))));
                $row->column(4, new Box('本月用户注册来源', view('admin.chars.month_register', compact('monthSites'))));
//
//                $allSites = compact('todaySite', 'weekSites', 'monthSites');
//                $row->column(4, new Box('成交量', view('admin.chars.order_count', $allSites)));
//                $row->column(4, new Box('有效成交量', view('admin.chars.order_pay_count', $allSites)));
//                $row->column(4, new Box('收入金额', view('admin.chars.sale_money', $allSites)));
            });
    }


}
