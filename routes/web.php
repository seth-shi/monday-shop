<?php

/****************************************
 * 商城前台路由组
 ****************************************/
Route::middleware('user.cars')->group(function () {

    Route::get('/', 'HomeController@index');

    // 1. 通过商品拼音首字母得到商品列表
    // 2. 搜索商品
    Route::get('products/pinyin/{pinyin}', 'ProductController@getProductsByPinyin');
    Route::get('products/search', 'ProductController@search');

    // 1. 商品分类的资源路由，
    // 2. 商品的资源路由哦
    // 3. 购物车的资源路由
    Route::resource('categories', 'CategoryController')->only('index', 'show');
    Route::resource('products', 'ProductController')->only('index', 'show');
    Route::resource('cars', 'CarController');

    // 优惠券兑换模板
    Route::get('coupon_templates', 'CouponTemplateController@index');
    // 领取优惠券
    Route::post('coupons', 'CouponController@store');

    // 秒杀商品
    Route::get('seckills/{id}', 'User\SeckillController@show');
    // 获取已经秒杀的人名
    Route::get('seckills/{id}/users', 'User\SeckillController@getSeckillUsers');
});

/****************************************
 * 用户相关的路由
 ****************************************/
Route::middleware('user.auth')->prefix('user')->namespace('User')->group(function(){

    /****************************************
     * 1. 用户的个人中心
     * 2. 订阅星期一商城以获取新闻
     ****************************************/
    Route::get('/', 'UserController@index');
    Route::put('subscribe', 'UserController@subscribe');

    /****************************************
     * 1. 修改密码页面
     * 2. 修改密码
     ****************************************/
    Route::get('password', 'UserController@showPasswordForm');
    Route::post('password', 'UserController@updatePassword');

    /****************************************
     * 1. 用户设置个人中心
     * 2. 修改用户头像
     * 3. 修改用户资料
     ****************************************/
    Route::get('setting', 'UserController@setting');
    Route::post('upload/avatar', 'UserController@uploadAvatar');
    Route::put('update', 'UserController@update');

    /****************************************
     * 1. 设置用户的默认收货地址
     * 2. 根据省份 id 获取城市列表
     * 3. 收货地址的资源路由
     ****************************************/
    Route::post('addresses/default/{address}', 'AddressController@setDefaultAddress');
    Route::get('addresses/cities', 'AddressController@getCities');
    Route::resource('addresses', 'AddressController');

    /****************************************
     * 1. 用户收藏商品的列表
     * 2. 收藏，取消收藏商品
     * 3. 订单的资源路由
     ****************************************/
    Route::get('likes', 'LikesController@index');
    Route::put('likes/{id}', 'LikesController@toggle');
    Route::resource('orders', 'OrderController')->only('index', 'show', 'destroy');

    // 确认收货
    Route::patch('orders/{order}/shipped', 'OrderController@confirmShip');
    // 完成订单+评价
    Route::post('orders/{order}/complete', 'OrderController@completeOrder');
    // 取消订单
    Route::get('orders/{order}/cancel', 'OrderController@cancelOrder');

    // 用户的积分
    Route::get('scores', 'UserController@indexScores');
    // 用户拥有的优惠券
    Route::get('coupons', 'UserCouponController@index');
    // 使用兑换码兑换优惠券
    Route::get('coupon_codes', 'UserCouponController@exchangeCoupon');


    // 用户通知的所有接口
    Route::get('notifications', 'NotificationController@index');
    // 标位已读
    Route::get('notifications/{id}/read', 'NotificationController@read');
    // 已读所有
    Route::get('notifications/read_all', 'NotificationController@readAll');
    // 查看通知详情
    Route::get('notifications/{id}', 'NotificationController@show');
    // 轮询未读消息总数
    Route::get('un_read_count/notifications', 'NotificationController@getUnreadCount');

    /****************************************
     * 1. 订单的创建（包括直接下单和购物车下单
     * 2. 退款接口
     * 3. 忘记付款了，再次付款
     ****************************************/
    // 统一创建订单
    Route::get('comment/orders/create', 'StoreOrderController@create');
    Route::post('comment/orders', 'StoreOrderController@store');

    // 退款和支付
    Route::post('pay/orders/{order}/refund', 'RefundController@store');
    Route::get('pay/orders/{order}/again', 'PaymentController@againStore');

    // 秒杀的订单创建接口
    Route::post('seckills/{id}', 'SeckillController@storeSeckill');
});


/****************************************
 * 互联登录的路由，包括 github, QQ， 微博 登录
 ****************************************/
Auth::routes();

Route::namespace('Auth')->group(function(){

    // 获取验证码
    Route::get('captcha', 'RegisterController@captcha');

    /****************************************
     * 1. 激活账号的路由
     * 2. 重新发送激活链接的路由
     ****************************************/
    Route::get('register/active/{token}', 'UserController@activeAccount');
    // again send active link
    Route::get('register/again/send/{id}', 'UserController@sendActiveMail');

    /****************************************
     * 互联登录的路由，包括 github, QQ， 微博 登录
     ****************************************/
    Route::get('auth/oauth/{type}', 'AuthLoginController@redirectToAuth');
    Route::get('auth/oauth/callback/{type}', 'AuthLoginController@handleCallback');
    Route::get('/auth/oauth/unbind/{type}', 'AuthLoginController@unBind');
});

// 支付通知的接口
Route::get('pay/return', 'PaymentNotificationController@payReturn')->middleware('user.cars');
Route::post('pay/notify', 'PaymentNotificationController@payNotify');

// 取消订阅邮件
Route::get('unsubscribe/{email}', 'HomeController@unSubscribe')->name('site.email');
