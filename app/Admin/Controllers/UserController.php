<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\ActiveUserAction;
use App\Admin\Transforms\UserSexTransform;
use App\Admin\Transforms\YesNoTransform;
use App\Enums\UserSexEnum;
use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Validation\Rule;

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
        $grid = new Grid(new User);

        $levels = Level::query()->orderBy('min_score', 'desc')->get();

        // 排序最新的
        $grid->model()->latest();

        $grid->column('id', 'Id');
        $grid->column('name', '用户名');
        $grid->column('sex', '性别')->display(function ($sex) {

            return UserSexTransform::trans($sex);
        });
        $grid->column('email', '邮箱')->display(function ($email) {
            return str_limit($email, 20);
        });
        $grid->column('avatar', '头像')->image('', 50, 50);
        $grid->column('github_name', 'Github');
        $grid->column('qq_name', 'QQ');
        $grid->column('weibo_name', '微博');
        $grid->column('level', '等级')->display(function () use ($levels) {

            $level = $levels->where('min_score', '<=', $this->score_all)->first();
            return optional($level)->name;
        });
        $grid->column('score_all', '总积分')->sortable();
        $grid->column('score_now', '剩余积分')->sortable();
        $grid->column('login_ip', '登录地址');
        $grid->column('login_count', '登录次数')->sortable();
        $grid->column('is_active', '是否激活')->display(function ($isActive) {

            return YesNoTransform::trans($isActive);
        });
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '修改时间');

        $grid->actions(function (Grid\Displayers\DropdownActions $actions) {

            if (! $actions->row->is_active) {

                $actions->add(new ActiveUserAction());
            }
        });

        // 筛选功能
        $levelOptions = $levels->pluck('name', 'id');
        $grid->filter(function (Filter $filter) use ($levelOptions) {
           $filter->disableIdFilter();
           $filter->like('name', '用户名');
           $filter->like('email', '邮箱');

           $filter->where(function ($query) {

               // 找到这个等级
               $level = Level::query()->findOrFail($this->input);
               // 找到下一个等级
               $high = Level::query()->where('min_score', '>', $level->min_score)->orderBy('min_score', 'asc')->first();


               $query->where('score_all', '>=', $level->min_score);
               if (! is_null($high)) {
                   $query->where('score_all', '<', $high->min_score);
               }

           }, '等级')->select($levelOptions);
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

            return UserSexTransform::trans($sex);
        });
        $show->field('email', '邮箱');
        $show->field('avatar', '头像')->image();
        $show->field('github_name', 'Github昵称');
        $show->field('qq_name', 'QQ昵称');
        $show->field('weibo_name', '微博昵称');
        $show->field('login_ip', '登录地址');
        $show->field('login_count', '登录次数');
        $show->field('is_active', '是否激活')->as(function ($isActive) {

            return YesNoTransform::trans($isActive);
        })->unescape();
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '修改时间');

        $show->addresses('收货地址', function (Grid $grid) {

            $grid->model()->latest();
            $grid->column('name', '收货人');
            $grid->column('phone', '收货人联系方式');
            $grid->column('detail_address', '详细地址');
            $grid->column('is_default', '是否默认')->display(function ($is) {

                return YesNoTransform::trans($is);
            });
            $grid->column('created_at', '创建时间');

            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableFilter();
            $grid->disableTools();
            $grid->disableRowSelector();
        });

        $show->scoreLogs('积分', function (Grid $grid) {

            $grid->model()->latest();
            $grid->column('description', '描述');
            $grid->column('score', '积分');
            $grid->column('created_at', '创建时间');

            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableFilter();
            $grid->disableTools();
            $grid->disableRowSelector();
        });

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

        $sexOptions = [UserSexEnum::MAN => '男', UserSexEnum::WOMAN => '女'];
        $form->select('sex', '性别')->rules(['required', Rule::in(array_keys($sexOptions))])->options($sexOptions)->default(1);
        $form->email('email', '邮箱')->rules(function (Form $form) {
            $rules = 'required|email|unique:users,email';

            // 更新操作
            if (! is_null($id = $form->model()->getKey())) {
                $rules .= ",{$id}";
            }

            return $rules;
        });
        // dd(windows_os());
        $form->password('password', '密码');
        $avatar = $form->image('avatar', '头像')->uniqueName()->move('avatars');

        if (! windows_os()) {
            $avatar->resize(160, 160);;
        }

        $form->switch('is_active', '激活');

        // 加密密码
        $form->saving(function (Form $form) {

            if ($form->password) {
                $form->password = bcrypt($form->password);
            } else {
                $form->password = $form->model()->password;
            }

        });

        return $form;
    }
}
