<?php

namespace App\Admin\Controllers;

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\OperationLog;
use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends BaseAuthController
{
    // 覆盖默认的
    public function index(Content $content)
    {
        return $content
            ->header(trans('admin.administrator'))
            ->description(trans('admin.list'))
            ->body($this->adminGrid()->render());
    }

    protected function adminGrid()
    {
        $userModel = config('admin.database.users_model');

        $grid = new Grid(new $userModel());

        $grid->column('id', 'ID')->sortable();
        $grid->column('username', trans('admin.username'));
        $grid->column('name', trans('admin.name'));
        $grid->column('login_ip', '登录ip');
        $grid->roles(trans('admin.roles'))->pluck('name')->label();
        $grid->column('created_at', trans('admin.created_at'));
        $grid->column('updated_at', trans('admin.updated_at'));

        $grid->actions(function (Grid\Displayers\DropdownActions $actions) {
            if ($actions->getKey() == 1) {
                $actions->disableDelete();
            }
        });


        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
        });

        return $grid;
    }


    public function indexLogs(Content $content)
    {
        return $content
            ->header(trans('admin.operation_log'))
            ->description(trans('admin.list'))
            ->body($this->logGrid());
    }

    /**
     * @return Grid
     */
    protected function logGrid()
    {
        $grid = new Grid(new OperationLog());

        $grid->model()->orderBy('id', 'DESC');

        $grid->column('id', 'ID')->sortable();
        $grid->column('user.name', '用户');
        $grid->column('method', '方法')->display(function ($method) {
            $color = array_get(OperationLog::$methodColors, $method, 'grey');

            return "<span class=\"badge bg-$color\">$method</span>";
        });
        $grid->column('path', '路径')->label('info');
        $grid->column('ip', '地址')->label('primary');
        $grid->column('description', '描述')->limit(20)->modal(function ($model) {

            return new Box('详情', $model->description ?: ' ');
        });
        $grid->column('input', '输入数据')->limit(20)->expand(function ($model) {

            $input = json_decode($model->input, true);
            $input = array_except($input, ['_pjax', '_token', '_method', '_previous_']);
            $codes = empty($input) ?
                '<code>{}</code>' :
                '<pre>'.json_encode($input, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE).'</pre>';

            return new Box('详情', $codes);
        });

        $grid->column('created_at', trans('admin.created_at'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableEdit();
            $actions->disableView();
        });

        $grid->disableCreateButton();

        $grid->filter(function (Grid\Filter $filter) {
            $userModel = config('admin.database.users_model');

            $filter->equal('user_id', 'User')->select($userModel::all()->pluck('name', 'id'));
            $filter->equal('method')->select(array_combine(OperationLog::$methods, OperationLog::$methods));
            $filter->like('path');
            $filter->equal('ip');
        });

        return $grid;
    }
}
