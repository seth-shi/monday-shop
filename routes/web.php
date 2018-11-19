<?php


/****************************************
 * 互联登录的路由，包括 github, QQ， 微博 登录
 ****************************************/
Auth::routes();

Route::namespace('Auth')->group(function(){

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
    Route::get('auth/oauth', 'AuthLoginController@redirectToAuth');
    Route::get('auth/oauth/callback', 'AuthLoginController@handleCallback');
    Route::get('/auth/oauth/unbind', 'AuthLoginController@unBind');
});

/****************************************
 * 主页相关的路由
 ****************************************/
Route::get('/', 'HomeController@index');

/****************************************
 * 1. 通过商品拼音首字母得到商品列表
 * 2. 搜索商品
 ****************************************/
Route::get('products/pinyin/{pinyin}', 'ProductsController@getProductsByPinyin');
Route::get('products/search', 'ProductsController@search');

/****************************************
 * 1. 商品分类的资源路由，
 * 2. 商品的资源路由哦
 * 3. 购物车的资源路由
 ****************************************/
Route::resource('categories', 'CategoriesController', ['only' => ['index', 'show']]);
Route::resource('products', 'ProductsController', ['only' => ['index', 'show']]);
Route::resource('cars', 'CarsController');

/****************************************
 * 用户相关的路由
 ****************************************/
Route::middleware(['user.auth'])->prefix('user')->namespace('User')->group(function(){

    /****************************************
     * 1. 用户的个人中心
     * 2. 订阅星期一商城以获取新闻
     * 3. 取消订阅
     ****************************************/
    Route::get('/', 'UsersController@index');
    Route::post('subscribe', 'UsersController@subscribe');
    Route::post('desubscribe', 'UsersController@deSubscribe');

    /****************************************
     * 1. 修改密码页面
     * 2. 修改密码
     ****************************************/
    Route::get('password', 'UsersController@showPasswordForm');
    Route::post('password', 'UsersController@updatePassword');

    /****************************************
     * 1. 用户设置个人中心
     * 2. 修改用户头像
     * 3. 修改用户资料
     ****************************************/
    Route::get('setting', 'UsersController@setting');
    Route::post('upload/avatar', 'UsersController@uploadAvatar');
    Route::put('update', 'UsersController@update');

    /****************************************
     * 1. 设置用户的默认收货地址
     * 2. 根据省份 id 获取城市列表
     * 3. 收货地址的资源路由
     ****************************************/
    Route::post('addresses/default/{address}', 'AddressesController@setDefaultAddress');
    Route::get('addresses/cities', 'AddressesController@getCities');
    Route::resource('addresses', 'AddressesController');

    /****************************************
     * 1. 用户收藏商品的列表
     * 2. 收藏，取消收藏商品
     * 3. 单个订单的下单
     * 4. 订单的资源路由
     ****************************************/
    Route::get('likes', 'LikesController@index');
    Route::put('likes/{id}', 'LikesController@toggle');
    Route::post('orders/single', 'OrdersController@single');
    Route::resource('/orders', 'OrdersController')->only('index', 'store', 'show', 'destroy');

    // 评论商品
    Route::post('comments', 'CommentCOntroller@store');

    /****************************************
     * 1. 支付的显示页面
     * 2. 支付的处理
     ****************************************/
    Route::post('pay/show', 'PaymentsController@index');
    Route::post('pay/store', 'PaymentsController@pay');
});
/****************************************
 * 1. 用户付费！如果验证了[user.auth]，
 *    就会发生无限跳转，所以放在外面
 ****************************************/
Route::get('user/pay/return', 'User\PaymentsController@payReturn');
Route::post('user/pay/notify', 'User\PaymentsController@payNotify');
