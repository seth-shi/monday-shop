<?php


/**
 * 根据路径生成一个图片标签
 *
 * @param string       $url
 * @param string $disk
 * @param int    $width
 * @param int    $height
 * @return string
 */
function image(string $url, string $disk = 'public', int $width = 50, int $height = 50) : string
{
    $url = imageUrl($url, $disk);

    return "<img width='{$width}' height='{$height}' src='{$url}' />";
}

function imageUrl(string $url, string $disk = 'public')
{
    static $driver  = null;

    if (is_null($driver)) {
        $driver = Storage::disk($disk);
    }

    if (! starts_with($url, 'http')) {
        $url = $driver->url($url);
    }

    return $url;
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
 * @param \App\Enums\SettingIndexEnum $settingEnum
 * @param null                        $default
 * @return mixed|null
 */
function setting(\App\Enums\SettingIndexEnum $settingEnum, $default = null)
{
    $key = \App\Models\Setting::cacheKey($settingEnum->getValue());

    $val = Cache::get($key);
    if (is_null($val)) {

        $val = \App\Models\Setting::query()->where('index_code', $settingEnum->getValue())->value('value');
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

/**
 * 响应 json
 *
 * @param int    $code
 * @param string $msg
 * @param array  $data
 * @return \Illuminate\Http\JsonResponse
 */
function responseJson($code = 200, $msg = 'success', $data = [])
{
    return response()->json(compact('code', 'msg', 'data'));
}
