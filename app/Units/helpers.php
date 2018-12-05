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
    return floor($price * 100) / 100;
}


/**
 * 或者设置的配置项
 *
 * @param      $indexName
 * @param null $default
 * @return mixed|null
 */
function setting($indexName, $default = null)
{
    $value = Cache::rememberForever("settings:{$indexName}", function () use ($indexName) {

        return \App\Models\Setting::query()->where('index_name', $indexName)->value('value');
    });

    if ($value) {

        return $value;
    }

    return $default;
}
