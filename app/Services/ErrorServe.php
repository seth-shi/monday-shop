<?php

namespace App\Services;


class ErrorServe
{
    const HTTP_OK = 200;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_AUTH_EXPIRED = 401;
    const HTTP_NOT_FOUND = 404;
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    /**********  There is no error message   **********/
    // Form validation does not pass
    const HTTP_FORM_VALIDATOR_ERROR = 499;

    public static $errCodes = [
        // 系统码
        '400' => '未知错误',
        '401' => '授权已过期，请重新登录',
        '404' => '找不到请求的内容',
        '500' => '服务器异常',
    ];

    public static function getErrorMsg($code)
    {
        return self::$errCodes[$code] ?? null;
    }
}
