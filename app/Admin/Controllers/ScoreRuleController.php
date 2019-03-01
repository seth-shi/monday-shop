<?php

namespace App\Admin\Controllers;

use App\Models\ScoreRule;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class ScoreRuleController extends Controller
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
            ->description('两个 % 包围起来的是变量模板')
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
            ->body($this->form($id)->edit($id));
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
        $grid = new Grid(new ScoreRule);

        $grid->model()->latest();

        $grid->column('id', 'id');
        $grid->column('description', '描述');
        $grid->column('score', '积分');
        $grid->column('max_times', '次数');
        $grid->column('can_delete', '删除')->display(function ($is) {
            return $is ? '是' : '否';
        });
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '修改时间');

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
        $show = new Show(ScoreRule::findOrFail($id));

        $show->field('id', 'id');
        $show->field('description', '描述');
        $show->field('score', '积分');
        $show->field('max_times', '次数');
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '修改时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @param null $id
     * @return Form
     */
    protected function form($id = null)
    {
        $form = new Form(new ScoreRule);

        // 只有新增才能改变类型
        $options = [ScoreRule::INDEX_CONTINUE_LOGIN => '连续登录', ScoreRule::INDEX_REVIEW_PRODUCT => '每日浏览商品'];

        if (is_null($id)) {

            $form->select('index_code', '类型')->options($options)->rules('required');
        }
        $form->number('score', '积分');


        if (! is_null($id)) {

            // 只有当时连续登录和修改的才有次数
            $scoreRule = ScoreRule::query()->findOrFail($id);
            $form->textarea('description', '描述');

            if (array_key_exists($scoreRule->index_code, $options)) {

                $form->number('max_times', '次数');
            }

        } else {

            $form->number('max_times', '次数');
        }


        $form->saving(function (Form $form) {

            // 如果是新建复制模板
            if (! $form->model()->exists) {


                $rule = ScoreRule::query()
                                 ->where('can_delete', 0)
                                 ->where('index_code', $form->index_code)
                                 ->firstOrFail();

                $form->model()->description = $rule->description;
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
        $rule = ScoreRule::query()->findOrFail($id);

        if (! $rule->can_delete) {

            return response()->json([
                                        'status'  => false,
                                        'message' => '这个等级不允许删除',
                                    ]);
        }

        if ($rule->delete()) {
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
