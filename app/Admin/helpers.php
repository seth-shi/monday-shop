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
function imageUrl(string $url, string $disk = 'public', int $width = 50, int $height = 50) : string
{
    static $driver  = null;

    if (is_null($driver)) {
        $driver = Storage::disk($disk);
    }


    if (! starts_with($url, 'http')) {
        $url = $driver->url($url);
    }


    return "<img width='{$width}' height='{$height}' src='{$url}' />";
}
