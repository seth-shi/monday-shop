<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        // $users =

        return $content
            ->header('数据统计')
            ->row(function (Row $row) {


                $row->column(4, new Box('Bar chart', view('admin.chart')));
                $row->column(4, new Box('Bar chart', view('admin.chart')));
                $row->column(4, new Box('Bar chart', view('admin.chart')));

            });
    }

}
