<?php


    return [
      'uid' => env('PAYSAPI_UID'),
      'token' => env('PAYSAPI_TOKEN'),
      'notify_url' => env('PAYSAPI_NOTIFY_URL', config('app.url') . '/user/pay/return'),
      'return_url' => env('PAYSAPI_RETURN_URL', config('app.url') . '/user/pay/notify'),
    ];
