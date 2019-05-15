<?php



$attributes = [
    'prefix' => 'v1',
    'namespace' => 'Api\V1'
];
Route::group($attributes, function () {

    // 这里的接口都必须登录
    Route::group(['middleware' => 'auth.api.refresh'], function () {


        Route::get('own/me', 'OwnController@me');


        Route::delete('tokens', 'AuthController@logout');
    });

    // 登录接口
    Route::post('tokens', 'AuthController@login');
});
