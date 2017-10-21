<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getActiveLink(User $user)
    {
        // 拼接提示消息
        $url = url('register/again/send/' . $user->id);
        $msg = "账户未激活， <a href='{$url}'>点击此重新发送激活邮件</a>";

        return $msg;
    }
}