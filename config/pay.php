<?php


    return [

        // 阿里支付
        'ali' => [
            'app_id' => env('ALIAPY_APP_ID'),
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApXFrJW7MG/RtApdr493uN1SIC+iZScwVQ5R5O0bmvRJL7VlmM547qioV+ag0hGsLoWpdY7FTIYktdNU/uNwg0XMGQTFEmbXnsCh20b96SAmNrlEn7aeEtIitIhuTVaOlDkTcOE5nRSHB0JwMZLlMd54BOPird7EBNsKl84rQVMiRSDYINFoDjDhROIYISIsLNxIRVQbZq11r8kjxSJ3Tkv896CTQHsrIcVXCAjoX/Hn5w5KrUpZ+IHDXAiRjCd9wYjkQpnc/+5XY1QSRkahTKb2ybHS6PDEbWdUHFlgbS9ALP4TfsTwK4zhQJUXaCdNKVw7L3tD1xHb0cLub+JbyAwIDAQAB',
            // 加密方式： **RSA2**
            'private_key' => 'MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCpdHsRTV8pz4IjvY0aXC7K8Pvu/vqsZeUHJ2QUfYDXjLjWrFqOU+3fkjf2kJAh7IZ21ln4x3te0xdGwuH0n49+VfF+ezLsUPJi5Pq8yVjvdIqziPKIhMAkGXSRInLizHE7563ui/SmJWt244vyO2vk3tjafeQ9v5U6RR5r/H5eUEg05S2/2F8ZyDVaGlKStDSQbXlkBjPvyCCkdOCxeJ9EJ3d6vyLFmiN4Na3ZNZUQDvQZ/75+Y1+NeHPn4wZpr7CwVYlLfdE74hYvdVCRM1ZffUC5h/CB49RqCnyc8d3vNpeN7QTnDIkb0X/yOMpxwcKtxn/8y1DxxCtMPq/NmDotAgMBAAECggEACiK9ebt3Bbkzv4+G8Ryyb9EaQKFfvRAbMuJYSiF3o2z3YV/NytWaVNUaI9VhyaWsJU+M8iR8bJ+TtNfTTB5/Jr9dQoN7+EafOOsZVFF20FvYMATw/Nlz5LThFA1LceVooHyrGqmkaIu0cdgKduK3AWmS7v64uDjNZD7eIvdnV5y8RpVntjir74K7m/d58ACBuHOPK3vTBF5+xyBjYyCuEBZnECSwC5sksiRiDTrR6cKObpSFkFK7a5uZtG4hPpyooUkw77HMSmFRA9XJpiZqqHyUN531zUOkgtOHLE2/BGBFbrhnOMuf9n5kEnWEAtgJjlzEv/BS2QKQTuJP8yvSwQKBgQD/IzhctcCRM5YZmgvi73iOM/TApYLLf40k55MXnoNVgaggdTQhyAyY6ZkLidNTxLVP1Dzm3ZLF14PLgdZRhOdIBPcj7f1MH+5qN3rOQx11P00BqRDQaHHcXaJc5xyzL2YPu1Dj6N1CR4qaDvsy8UNi0yFwS0ZTU9nktfbYSpUbhwKBgQCqBx3G4EWjkaVdqel6pKQG86MQk//ZRlXx93Niccc8ID8iWWmOCFDq3W5id0tSwi04kuQCJxCd/69Y/ADXlo1r8DaLcjivJ5ocezECDECq3NelMLcIYO0mpXtS69ibdaxdDDh5uyATfahtqzwf1m7voc6nay4VCjsrUzxskvYxqwKBgFTbPPKwzIQ+mQyYzJ1Esl7xbtTn93GBUctVbfmsEdhNkEKDWLxnkbEF+I364Bt7UCZl23+ZcCh2/nGgFEz2nAm7BQuhKt63vA79ts2FSvXlANKtjVcTddMqHUcy4rvB5vsSfNvgZj6WFsYYd3nA/n2O5Q85KgGq4MyNrLTRUXhfAoGAX7Q7vYrVh/leRHd0dVUhAsy2t4km1QzzKYyohPwYMi7QeqwrbwgdS+Yx0PjnDAFCZPrBnriQcO7Pq13Ft5QFrID8osc7QtQeufNZpZZx+/rs4w2lqPCt7DfvT8BzHyZAS+uqClMa/f2YBYsB/8W6keXZJYF94dftcDic5VxfeZsCgYA681m3QEYIYkJn44wPhvbuKX+eqtMEhlmKWEc6NoMKtWRqDGuaX84sfPxN2UO+CzYlDVEWi3NKY0tWNWNwiep9Z+/tJgrCxDkEGaoxwDo+wC2Wk5bYMUp2Ot58o8Ee1Xghd+9d7AHKkWS3VRa2M4g+AFjSh4in+leIj13N3v1iEA==',
            'notify_url' =>  config('app.url') . '/alipay/return',
            'return_url' =>  config('app.url') . '/alipay/notify',
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
