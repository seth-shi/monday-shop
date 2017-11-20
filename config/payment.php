<?php

    return [
      'uid' => env('PAYSAPI_UID'),
      'token' => env('PAYSAPI_TOKEN'),
      'notify_url' => url('/user/pay/notify'),
      'return_url' => url('/user/pay/return'),
    ];