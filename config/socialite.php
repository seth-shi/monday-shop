<?php

return [
    //...
    'github' => [
        'client_id'     => env('OAUTH_GITHUB_ID'),
        'client_secret' => env('OAUTH_GITHUB_SECRET'),
        'redirect'      => env('OAUTH_GITHUB_REDIRECT'),
    ],
    'qq' => [
        'client_id'     => env('OAUTH_QQ_ID'),
        'client_secret' => env('OAUTH_QQ_SECRET'),
        'redirect'      => env('OAUTH_QQ_REDIRECT'),
    ],
    'weibo' => [
        'client_id'     => env('OAUTH_WEIBO_ID'),
        'client_secret' => env('OAUTH_WEIBO_SECRET'),
        'redirect'      => env('OAUTH_WEIBO_REDIRECT'),
    ],
];