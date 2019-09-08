<?php

require __DIR__ . '/response.php';

/**
 * 根据路径生成一个图片标签
 *
 * @param string       $url
 * @param string $disk
 * @param int    $width
 * @param int    $height
 * @return string
 */
function image($url, $disk = 'public', int $width = 50, int $height = 50) : string
{
    if (is_null($url) || empty($url)) {

        $url = get404Image();
    } else {

        $url = assertUrl($url, $disk);
    }

    return "<img width='{$width}' height='{$height}' src='{$url}' />";
}

function assertUrl($url, $disk = 'public')
{
    static $driver  = null;

    if (is_null($url) || empty($url)) {

        return get404Image();
    }

    if (is_null($driver)) {
        $driver = Storage::disk($disk);
    }

    if (! starts_with($url, 'http')) {
        $url = $driver->url($url);
    }

    return $url;
}

function get404Image()
{
    return asset('images/404.jpg');
}


/**
 * 把字符串变成固定长度
 *
 * @param     $str
 * @param     $length
 * @param     $padString
 * @param int $padType
 * @return bool|string
 */
function fixStrLength($str, $length, $padString = '0', $padType = STR_PAD_LEFT)
{
    if (strlen($str) > $length) {
        return substr($str, strlen($str) - $length);
    } elseif (strlen($str) < $length) {
        return str_pad($str, $length, $padString, $padType);
    }

    return $str;
}


/**
 * 价格保留两位小数
 *
 * @param $price
 * @return float|int
 */
function ceilTwoPrice($price)
{
    return round($price, 2);
}


/**
 * 或者设置的配置项
 *
 * @param \App\Enums\SettingKeyEnum $settingEnum
 * @param null                        $default
 * @return mixed|null
 */
function setting(\App\Enums\SettingKeyEnum $settingEnum, $default = null)
{
    $key = \App\Models\Setting::cacheKey($settingEnum->getValue());

    $val = Cache::get($key);
    if (is_null($val)) {

        $val = \App\Models\Setting::query()->where('key', $settingEnum->getValue())->value('value');
        if (is_null($val)) {
            return $default;
        }

        Cache::put($key, $val);
    }

    return $val;
}

/**
 * 生成系统日志
 *
 * @param       $description
 * @param array $input
 */
function createSystemLog($description, $input = [])
{
    $operate = new \Encore\Admin\Auth\Database\OperationLog();
    $operate->path = config('app.url');
    $operate->method = 'GET';
    $operate->ip = '127.0.0.1';
    $operate->input = json_encode($input);
    $operate->description = $description;
    $operate->save();
}
