<?php

namespace App\Admin\Controllers;

use App\Models\Level;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class LevelController extends Controller
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
            ->header('列表')
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
            ->header('详情')
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
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('新建')
            ->description('')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Level);

        $grid->model()->orderBy('min_score', 'desc');


        $grid->column('id', 'id');
        $grid->column('icon', '图标')->image('', 90, 90);
        $grid->column('name', '名字')->editable();
        $grid->column('level', '等级');
        $grid->column('min_score', '分阶');
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '更新时间');


        $grid->actions(function (Grid\Displayers\Actions $actions) {

            $level = $actions->row;
            if (! $level->can_delete) {
                $actions->disableDelete();
            }
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
        $show = new Show(Level::findOrFail($id));

        $show->field('id', 'id');
        $show->field('icon', '图标')->image();
        $show->field('name', '名字');
        $show->field('level', '等级');
        $show->field('min_score', '分阶');
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '更新时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Level);

        $icon = $form->image('icon', '图标')->uniqueName();
        if (! windows_os()) {
            $icon->resize(160, 160);;
        }

        $form->text('name', '名字');
        $form->number('level', '等级');
        $form->number('min_score', '积分');
    
        $form->saving(function (Form $form) {
        
            if (app()->environment('dev')) {
            
                admin_toastr('开发环境不允许操作', 'error');
                return back()->withInput();
            }
        });
        

        return $form;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $level = Level::query()->findOrFail($id);

        if (! $level->can_delete) {

            return response()->json([
                'status'  => false,
                'message' => '这个等级不允许删除',
            ]);
        }

        if ($level->delete()) {
            $data = [
                'status'  => true,
                'message' => trans('admin.delete_succeeded'),
            ];
        } else {
            $data = [
                'status'  => false,
                'message' => trans('admin.delete_failed'),
            ];
        }

        return response()->json($data);
    }
}
