<?php

return [
    //...
    'github' => [
        'client_id'     => env('OAUTH_GITHUB_ID'),
        'client_secret' => env('OAUTH_GITHUB_SECRET'),
        'redirect'      => config('app.url') . '/auth/oauth/callback/github',
    ],
    'qq' => [
        'client_id'     => env('OAUTH_QQ_ID'),
        'client_secret' => env('OAUTH_QQ_SECRET'),
        'redirect'      => config('app.url') . '/auth/oauth/callback/qq',
    ],
    'weibo' => [
        'client_id'     => env('OAUTH_WEIBO_ID'),
        'client_secret' => env('OAUTH_WEIBO_SECRET'),
        'redirect'      => config('app.url') . '/auth/oauth/callback/weibo',
    ],
];
