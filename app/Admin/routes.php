<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');


    // 分类
    // 商品
    $router->resource('categories', 'CategoryController');
    $router->resource('products', 'ProductController');

    // 订单
    $router->resource('orders', 'OrderController');

    // 会员管理
    $router->resource('users', 'UserController');

    // 图片上传
    $router->post('upload/editor', 'UploadController@uploadByEditor');
});
