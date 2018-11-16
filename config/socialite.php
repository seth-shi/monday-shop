<?php

return [
    //...
    'github' => [
        'client_id'     => env('OAUTH_GITHUB_ID'),
        'client_secret' => env('OAUTH_GITHUB_SECRET'),
        'redirect'      => config('app.url') . '/auth/github/callback',
    ],
    'qq' => [
        'client_id'     => env('OAUTH_QQ_ID'),
        'client_secret' => env('OAUTH_QQ_SECRET'),
        'redirect'      => config('app.url') . '/auth/qq/callback',
    ],
    'weibo' => [
        'client_id'     => env('OAUTH_WEIBO_ID'),
        'client_secret' => env('OAUTH_WEIBO_SECRET'),
        'redirect'      => config('app.url') . '/auth/weibo/callback',
    ],
];
