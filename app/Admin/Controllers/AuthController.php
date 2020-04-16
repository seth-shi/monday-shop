<?php

namespace App\Admin\Controllers;

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseAuthController
{


    /**
     * 覆盖默认的登录方法
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function postLogin(Request $request)
    {
        $credentials = $request->only([$this->username(), 'password']);

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($credentials, [
            $this->username()   => 'required',
            'password'          => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        if ($this->guard()->attempt($credentials)) {

            // 验证是否登录的 ip
            $this->authenticated($this->guard()->user());

            // 记录登录日期
            return $this->sendLoginResponse($request);
        }

        return back()->withInput()->withErrors([
            $this->username() => $this->getFailedLoginMessage(),
        ]);
    }

    /**
     * 登录之后提示 ip 地址
     *
     * @param Administrator $user
     */
    protected function authenticated(Administrator $user)
    {
        $ip = request()->getClientIp();

        // 如果两次 ip 不一样, 提示风险
        if (! is_null($user->login_ip) && $ip != $user->login_ip) {

            admin_info('上一次登录的地址与本次不同,如果不是本人操作,建议及时修改密码');
        }

        $user->login_ip = $ip;
        $user->save();
    }
    
    public function putSetting()
    {
        $form = $this->settingForm();
        
        $form->submitted(function (Form $form) {
    
            if (app()->environment('dev')) {
        
                admin_toastr('开发环境不允许操作', 'error');
                return back()->withInput();
            }
        });
        
        return $form->update(Admin::user()->id);
    }
}
