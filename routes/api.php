<?php



$attributes = [
    'prefix' => 'v1',
    'namespace' => 'Api\V1'
];
Route::group($attributes, function () {

    // 这里的接口都必须登录
    Route::group(['middleware' => ['auth.api.refresh', 'auth.login.score']], function () {


        // 获取分类
        // 分类下的所有商品
        Route::get('categories', 'CategoryController@index');
        Route::get('categories/{category}/products', 'CategoryController@getProducts');
        // 获取商品详情
        Route::get('products/{uuid}', 'ProductController@show');

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
