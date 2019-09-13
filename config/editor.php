<?php
/**
 * Created by PhpStorm.
 * User: youxingxiang
 * Date: 2019/5/20
 * Time: 10:33 AM
 */
return [
    'route' => [

        'prefix' => env('ADMIN_ROUTE_PREFIX', 'yxx'),

        'namespace' => 'Yxx\\Kindeditor\\Controllers',

        'middleware' => ['web'],
    ],

    'up_config' => [
        "image_size"    => 1024*1024*3,                                                 // 上传图片大小
        "file_size"     => 1024*1024*100,                                               // 上传文件大小
        "media_size"    => 1024*1024*100,                                               // 上传视音频大小
        "flash_size"    => 1024*1024*100,                                               // 上传flash大小
        "image_format"  => "jpg,gif,jpeg,png,bmp,svg",                                  // 上传图片格式
        "file_format"   => "doc,docx,xls,xlsx,ppt,htm,html,txt,rar,zip,mp4,pdf,pptx",   // 上传文件格式
        "media_format"  => "mp3,mp4,avi",                                               // 上传视音频格式
        "flash_format"  => "swf,fla",                                                   // 上传flash格式
        "upload_path"   => "uploads",                                                   // 上传文件目录
    ],
];