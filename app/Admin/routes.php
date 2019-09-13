<?php

use App\Admin\Controllers\CouponLogController;
use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->fallback('HomeController@noFound');
    $router->get('/', 'HomeController@index');

    // 覆盖默认的用户管理
    $router->get('auth/users', 'AdminController@index');
    // 覆盖默认的操作日志
    $router->get('auth/logs', 'AdminController@indexLogs');

    // 系统的配置
    $router->resource('settings', 'SettingController')->only('index', 'store');

    // 商品上架下架
    $router->get('products/{id}/push', 'ProductController@pushProduct');

    // 分类
    // 商品
    // 秒杀的商品管理
    $router->resource('categories', 'CategoryController');
    $router->resource('products', 'ProductController');
    $router->resource('seckills', 'SeckillController')->only('index', 'create', 'store', 'destroy');

    // 商品发货
    // 管理员帮忙确认收货
    $router->post('orders/{order}/ship', 'OrderController@ship');
    $router->patch('orders/{order}/shipped', 'OrderController@confirmShip');

    // 退款
    // 订单
    // 评论
    $router->get('orders/{order}/refund', 'OrderController@refund');
    $router->resource('orders', 'OrderController');
    $router->resource('comments', 'CommentController');

    // 会员管理
    $router->resource('users', 'UserController');

    // 积分日志
    $router->get('score_logs', 'ScoreLogController@index');
    // 用户购物车数据
    $router->get('cars', 'CarController@index');
    // 用户收藏数据
    $router->get('user_like_products', 'ProductLikeController@index');


    // 积分规则, 积分等级
    $router->resource('score_rules', 'ScoreRuleController');
    $router->resource('levels', 'LevelController');

    // 优惠券管理
    $router->resource('coupon_templates', 'CouponTemplateController');
    // 优惠券
    $router->resource('coupon_logs', 'CouponLogController')->only('index');
    // 优惠券兑换码
    $router->resource('coupon_codes', 'CouponCodeController')->only('index', 'create', 'store', 'destroy');

    // 发布文章通知
    $router->resource('article_notifications', 'ArticleNotificationController')->only('index', 'create', 'store', 'show', 'destroy');

    // 富文本图片上传
    $router->post('upload/editor', 'UploadController@uploadByEditor');
    // 通过分类异步加载商品下拉列表
    $router->get('api/products', 'CategoryController@getProducts');
});
