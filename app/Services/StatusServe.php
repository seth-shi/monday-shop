<?php

namespace App\Services;

use Illuminate\Http\Response;

class StatusServe extends Response
{
    const EMAIL_AUTH_FAILED = 499;
    /**
     * 通过状态码获取默认的响应消息。
     * @param $statusCode
     * @return string
     */
    public static function getStatusMsg($statusCode)
    {
        return array_key_exists($statusCode, self::$statusTexts) ? self::$statusTexts[$statusCode] : 'SUCCESS';
    }
}