<?php

return [
    'hosts' => [
        env('ELASTIC_SEARCH_HOST', '127.0.0.1:9200')
    ],

    'default_index' => 'monday_shop',
];
