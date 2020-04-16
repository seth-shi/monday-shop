<?php

namespace App\Admin\Controllers;

use App\Models\ArticleNotification;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticleNotificationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '通知文章';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ArticleNotification);

        $grid->model()->latest();

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('created_at', __('Created at'));

        $grid->filter(function (Grid\Filter $filter) {

            $filter->like('id', __('Id'));
            $filter->like('title', __('Title'));
        });

        $grid->actions(function (Grid\Displayers\DropdownActions $actions) {

            $actions->disableEdit();
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(ArticleNotification::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('content', __('Content'))->unescape();
        $show->field('created_at', __('Created at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ArticleNotification);

        $form->text('title', __('Title'))->help('请再三确认再发布，不可修改');
        $form->kindeditor('content', __('Content'));
    
        $form->saving(function (Form $form) {
        
            if (app()->environment('dev')) {
            
                admin_toastr('开发环境不允许操作', 'error');
                return back()->withInput();
            }
        });
    
        $form->deleting(function (Form $form) {
        
            if (app()->environment('dev')) {
            
                admin_toastr('开发环境不允许操作', 'error');
                return back()->withInput();
            }
        });

        return $form;
    }
}
