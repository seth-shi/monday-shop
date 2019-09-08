<?php

namespace App\Admin\Controllers;

use App\Enums\SettingKeyEnum;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Illuminate\Http\Request;

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
            ->body(function (Row $row) {


                $settingKeys = $this->getSettingKeys();

                $settings = [];
                foreach ($settingKeys as $key) {

                    $settings[$key] = setting(new SettingKeyEnum($key));
                }

                $form = new \Encore\Admin\Widgets\Form($settings);
                $form->action(admin_url('settings'));
                $form->method('POST');
                $form->hidden('_token', csrf_token());


                $form->text(SettingKeyEnum::USER_INIT_PASSWORD, '会员初始密码')->required();
                $form->decimal(SettingKeyEnum::UN_PAY_CANCEL_TIME, '订单自动取消时间')->required()->help('单位：分钟');
                $form->decimal(SettingKeyEnum::POST_AMOUNT, '邮费')->required()->help('设置为 0 免邮');

                $states = [
                    'on'  => ['value' => 1, 'text' => '打开', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
                ];

                $seckillStatus = \setting(new SettingKeyEnum(SettingKeyEnum::IS_OPEN_SECKILL)) ? '开启' : '关闭';
                $seckillHelp = "秒杀现在是 {$seckillStatus} 状态";
                $form->switch(SettingKeyEnum::IS_OPEN_SECKILL, '是否开启秒杀')->states($states)->help($seckillHelp);

                $row->column(12, new Box('网站配置', $form));
            });
    }

    public function store(Request $request)
    {
        // 对秒杀这个特殊的 key 做处理
        $val = strtolower($request->input(SettingKeyEnum::IS_OPEN_SECKILL)) == 'on' ? 1 : 0;
        $request->offsetSet(SettingKeyEnum::IS_OPEN_SECKILL, $val);

        $this->validate($request, [
            SettingKeyEnum::USER_INIT_PASSWORD => 'required|string',
            SettingKeyEnum::UN_PAY_CANCEL_TIME => 'required|integer|min:0',
            SettingKeyEnum::IS_OPEN_SECKILL => 'required|int|in:0,1',
            SettingKeyEnum::POST_AMOUNT => 'required|numeric|min:0',
        ]);


        $settingKeys = $this->getSettingKeys();
        foreach ($settingKeys as $key) {

            Setting::query()->where('key', $key)->update(['value' => $request->input($key)]);
        }

        admin_success('修改成功');
        return back();
    }

    private function getSettingKeys()
    {
        return [
            SettingKeyEnum::USER_INIT_PASSWORD,
            SettingKeyEnum::UN_PAY_CANCEL_TIME,
            SettingKeyEnum::POST_AMOUNT,
            SettingKeyEnum::IS_OPEN_SECKILL,
        ];
    }
}
