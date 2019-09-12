<?php

namespace App\Admin\Controllers;

use App\Enums\UserSexEnum;
use App\Enums\UserSourceEnum;
use App\Models\CouponCode;
use App\Models\CouponTemplate;
use App\Models\User;
use App\Notifications\CouponCodeNotification;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Ramsey\Uuid\Uuid;

class CouponCodeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '优惠券兑换码';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CouponCode);

        $grid->model()->latest();

        $grid->column('id', __('Id'));
        $grid->column('code', '兑换码');
        $grid->column('user_id', __('User id'));
        $grid->column('template_id', '优惠券ID');

        $grid->column('user.name', '会员名');
        $grid->column('template.title', '优惠券名');

        $grid->column('used_at', __('Used at'));
        $grid->column('notification_at', '上一次发送通知时间');
        $grid->column('created_at', __('Created at'));


        $grid->filter(function (Grid\Filter $filter) {

            $filter->equal('code', '兑换码');
            $filter->like('user.name', '会员名');
            $filter->equal('template.title', '优惠券名');
            $filter->between('used_at')->datetime();
        });

        $grid->actions(function (Grid\Displayers\Actions $actions) {

            $actions->disableEdit();
            $actions->disableView();
        });

        return $grid;
    }


    public function store()
    {
        $request = request();

        /**
         * 发放的优惠券不能为空
         * @var $template CouponTemplate
         */
        $template = CouponTemplate::query()->findOrFail($request->input('template_id'));
        $today = Carbon::today();
        if ($today->gt(Carbon::make($template->end_date))) {

            admin_error('优惠券已过期');
            return back()->withInput();
        }

        // 如果会员 ID 不为空，则代表是指定会员发放
        if ($userIds = $request->input('user_ids')) {

            // 使用空格拆分 id
            $ids = array_values(array_filter(explode(' ', $userIds)));
            $users = User::query()->findMany($ids);
        }
        // 否则则是条件范围发放
        else {

            $query = User::query();
            // 性别
            $sex = array_filter($request->input('user_sex'));
            // 会员来源
            $sources = array_filter($request->input('user_source'));
            // 登录次数
            $loginCount = (int)$request->input('login_count');
            // 会员总积分
            $scoreAll = (int)$request->input('user_score');

            $query->whereIn('sex', $sex)
                  ->whereIn('source', $sources)
                  ->where('login_count', '>=', $loginCount)
                  ->where('score_all', '>=', $scoreAll);
            $users = $query->get();
        }


        // 开始根据用户发放
        $now = Carbon::now()->toDateTimeString();
        $notifications = collect();
        $codes = $users->map(function (User $user) use ($template, $notifications, $now) {

            $code = strtoupper(str_random(16));

            $notification = [
                'id' => Uuid::uuid4()->toString(),
                'type' => CouponCodeNotification::class,
                'notifiable_id' => $user->id,
                'notifiable_type' => get_class($user),
                'data' => json_encode((new CouponCodeNotification($template, $code))->toArray($user), JSON_UNESCAPED_UNICODE),
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $notifications->push($notification);

            return [
                'code' => $code,
                'user_id' => $user->id,
                'template_id' => $template->id,
                'notification_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        });


        $size = 1000;
        foreach (array_chunk($codes->all(), $size, true) as $chunk) {
            // 优惠券码
            CouponCode::query()->insert($codes->all());
        }
        foreach (array_chunk($notifications->all(), $size, true) as $chunk) {
            // 通知
            DatabaseNotification::query()->insert($chunk);
        }

        admin_toastr("发布成功，总共有{$users->count()}位会员符合发放条件");
        return response()->redirectTo(admin_url('/coupon_codes'));
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CouponCode);

        $today = Carbon::today()->toDateString();

        $form->divider('指定会员发放');
        $form->text('user_ids', '会员')->help('请输入会员的ID, 多个会员用空格隔开，如果为空则代表是范围发放');

        $form->divider('范围发放');
        $templates = CouponTemplate::query()->where('end_date', '>=', $today)->pluck('title', 'id');
        $form->checkbox('user_sex', '会员性别')->options([UserSexEnum::MAN => '男', UserSexEnum::WOMAN => '女'])->canCheckAll();
        $form->checkbox('user_source', '会员来源')->options([
                                                            UserSourceEnum::MOON => '前台注册',
                                                            UserSourceEnum::GITHUB => 'Github',
                                                            UserSourceEnum::QQ => 'QQ',
                                                            UserSourceEnum::WEIBO => '微博',
                                                        ])->canCheckAll();
        $form->number('login_count', '会员登录次数')->default(0)->help('会员登录次数大于等于给定的次数');
        $form->number('user_score', '会员总积分')->default(0)->help('会员给定的积分大于等于总积分');

        $form->divider('优惠券');

        $form->select('template_id', '优惠券')->help('发放的优惠券')->options($templates)->required();

        return $form;
    }
}
