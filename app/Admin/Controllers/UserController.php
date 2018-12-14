<?php

namespace App\Admin\Controllers;

use App\Admin\Transforms\UserTransform;
use App\Models\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;

class UserController extends Controller
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
            ->header('会员列表')
            ->description('description')
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
            ->header('Detail')
            ->description('description')
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
            ->description('description')
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
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        // 排序最新的
        $grid->model()->latest();

        $grid->column('id', 'Id');
        $grid->column('name', '用户名');
        $grid->column('sex', '性别')->display(function ($sex) {
            return User::SEXES[$sex] ?? '未知';
        });
        $grid->column('email', '邮箱');
        $grid->column('avatar', '头像')->display(function ($avatar) {
            return image($avatar);
        });
        $grid->column('github_name', 'Github昵称');
        $grid->column('qq_name', 'QQ昵称');
        $grid->column('weibo_name', '微博昵称');
        $grid->column('login_count', '登录次数')->sortable();
        $grid->column('is_active', '是否激活')->display(function ($isActive) {

            return UserTransform::getInstance()->transStatus($isActive);
        });
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '修改时间');


        // 筛选功能
        $grid->filter(function (Filter $filter) {
           $filter->disableIdFilter();
           $filter->like('name', '用户名');
           $filter->like('email', '邮箱');
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', 'Id');
        $show->field('name', '用户名');
        $show->field('sex', '性别')->as(function ($sex) {
            return User::SEXES[$sex] ?? '未知';
        });
        $show->field('email', '邮箱');
        $show->field('avatar', '头像')->as(function ($avatar) {
            return image($avatar);
        });
        $show->field('github_name', 'Github昵称');
        $show->field('qq_name', 'QQ昵称');
        $show->field('weibo_name', '微博昵称');
        $show->field('login_count', '登录次数');
        $show->field('is_active', '是否激活')->display(function ($isActive) {
            return $isActive == User::ACTIVE_STATUS
                ? "<span class='label' style='color: green;'>激活</span>"
                : "<span class='label' style='color: red;'>未激活</span>";
        });
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '修改时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        // 前台用户注册必须要有这个 token，兼容一下
        $form = new Form(tap(new User, function ($user) {
            $user->active_token = str_random(60);
        }));

        $form->text('name', '用户名')->rules(function (Form $form) {
            $rules = 'required|unique:users,id';

            // 更新操作
            if (! is_null($id = $form->model()->getKey())) {
                $rules .= ",{$id}";
            }

            return $rules;
        });
        $form->select('sex', '性别')->rules('required|in:0,1')->options(User::SEXES)->default(1);
        $form->email('email', '邮箱')->rules(function (Form $form) {
            $rules = 'required|email|unique:users,email';

            // 更新操作
            if (! is_null($id = $form->model()->getKey())) {
                $rules .= ",{$id}";
            }

            return $rules;
        });
        $form->password('password', '密码');
        $form->image('avatar', '头像')->uniqueName()->move('avatars');

        $form->switch('is_active', '激活');

        return $form;
    }
}
