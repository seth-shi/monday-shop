<?php


    return [

        // 阿里支付
        'ali' => [
            'app_id' => env('ALIAPY_APP_ID'),
            'ali_public_key' => '',
            // 加密方式： **RSA2**
            'private_key' => '',
            'return_url' =>  config('app.url') . '/pay/return',
            'notify_url' =>  config('app.url') . '/pay/notify',
            'log' => [ // optional
                       'file' => storage_path('logs/alipay.log'),
                       'level' => 'debug', // 建议生产环境等级调整为 info，开发环境为 debug
                       'type' => 'single', // optional, 可选 daily.
                       'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'http' => [ // optional
                        'timeout' => 5.0,
                        'connect_timeout' => 5.0,
                        // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
            ],
            'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
        ],

    ];
