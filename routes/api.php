<?php



$attributes = [
    'prefix' => 'v1',
    'namespace' => 'Api\V1'
];
Route::group($attributes, function () {

    // 这里的接口都必须登录
    Route::group(['middleware' => ['auth.api.refresh', 'auth.login.score']], function () {


        // 个人基本信息
        Route::get('own/me', 'OwnController@me');
        // 个人基本记录
        Route::get('own/score_logs', 'OwnController@scoreLogs');

        Route::delete('tokens', 'AuthController@logout');
    });

    // 登录接口
    Route::post('tokens', 'AuthController@login');
    // 注册的接口
    Route::post('users', 'AuthController@register');
});
