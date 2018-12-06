<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    // 系统的配置
    $router->resource('settings', 'SettingController')->only('index', 'show', 'edit', 'update');

    // 商品上架下架
    $router->get('products/{id}/push', 'ProductController@pushProduct');

    // 分类
    // 商品
    // 秒杀的商品管理
    $router->resource('categories', 'CategoryController');
    $router->resource('products', 'ProductController');
    $router->resource('seckills', 'SeckillController')->only('index', 'create', 'store');

    // 订单
    // 评论
    $router->resource('orders', 'OrderController');
    $router->resource('comments', 'CommentController');

    // 会员管理
    $router->resource('users', 'UserController');

    // 富文本图片上传
    $router->post('upload/editor', 'UploadController@uploadByEditor');
    // 通过分类异步加载商品下拉列表
    $router->get('api/products', 'CategoryController@getProducts');
});
