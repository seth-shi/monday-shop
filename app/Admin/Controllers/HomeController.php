<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Div;
use App\Http\Controllers\Controller;
use App\Models\SiteCount;
use App\Models\User;
use App\Services\SiteCountService;
use Carbon\Carbon;
use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;

class HomeController extends Controller
{
    public function index(Content $content, SiteCountService $service)
    {
        // 用于更新菜单数据到文件， 可删除
//        file_put_contents(database_path('data/menus.json'), Menu::all()->toJson(JSON_UNESCAPED_UNICODE));

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
                                      ->push($todaySite)
                                      ->sortBy('date');


                // 本月统计
                $month = $now->format('Y-m');
                $monthSites = SiteCount::query()
                                       ->where('date', '!=', $today)
                                       ->where('date', '>', $month)
                                       ->get()
                                       ->push($todaySite)
                                       ->sortBy('date');


                $row->column(4, new Box('今日用户注册来源', new Div('todayRegister')));
                $row->column(4, new Box('七日用户注册来源', new Div('weekRegister')));
                $row->column(4, new Box('本月用户注册来源', new Div('monthRegister')));

                $row->column(4, new Box('今日订单', new Div('todayOrders')));
                $row->column(4, new Box('近期订单量', new Div('weekSites')));
                $row->column(4, new Box('交易金额', new Div('saleMoney')));

                $allSites = compact('todaySite', 'weekSites', 'monthSites');
                $row->column(12, view('admin.chars.echart', $allSites));
            });
    }


    /**
     * 自定义 404 页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function noFound()
    {
        return redirect('admin');
    }
}
