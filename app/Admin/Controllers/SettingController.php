<?php

namespace App\Admin\Controllers;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class SettingController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('配置列表')
            ->description('')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('配置详情')
            ->description('')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('')
            ->body($this->editForm($id)->edit($id));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Setting);

        $grid->column('id');
        $grid->column('index_code', '索引名');
        $grid->column('value', '配置值')->editable();
        $grid->column('description', '描述');
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '修改时间');


        $grid->disableCreateButton();
        $grid->disableRowSelector();

        $grid->actions(function (Grid\Displayers\Actions $actions) {

            $actions->disableDelete();
        });

        $grid->filter(function (Grid\Filter $filter) {

            $filter->disableIdFilter();
            $filter->like('index_code', '索引名');
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
        $show = new Show(Setting::query()->findOrFail($id));

        $show->field('id');
        $show->field('index_code', '索引名');
        $show->field('value', '配置值');
        $show->field('description', '描述');
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '修改时间');

        return $show;
    }

    public function update($id)
    {
        return $this->editForm($id)->update($id);
    }

    protected function editForm($id)
    {
        $form = new Form(new Setting);


        $setting = Setting::query()->findOrFail($id);

        $form->text('index_code', '索引名')->disable();
        $form->{$setting->type}('value', '配置值');
        $form->text('description', '描述');

        return $form;
    }

    /**
     * 禁止删除
     *
     * @param $id
     */
    public function destroy($id)
    {
        abort(403);
    }
}
