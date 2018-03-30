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
    Route::get('/register/active/{token}', 'UserController@activeAccount');
    // again send active link
    Route::get('/register/again/send/{id}', 'UserController@sendActiveMail');

    /****************************************
     * 互联登录的路由，包括 github, QQ， 微博 登录
     ****************************************/
    Route::get('/auth/github', 'AuthLoginController@redirectToGithub');
    Route::get('/auth/github/callback', 'AuthLoginController@handleGithubCallback');
    Route::get('/auth/qq', 'AuthLoginController@redirectToQQ');
    Route::get('/auth/qq/callback', 'AuthLoginController@handleQQCallback');
    Route::get('/auth/weibo', 'AuthLoginController@redirectToWeibo');
    Route::get('/auth/weibo/callback', 'AuthLoginController@handleWeiboCallback');
});

/****************************************
 * 主页相关的路由
 ****************************************/
Route::get('/', 'Home\HomeController@index');
Route::prefix('home')->namespace('Home')->group(function(){
    Route::get('/', 'HomeController@index');

    /****************************************
     * 1. 通过商品拼音首字母得到商品列表
     * 2. 搜索商品
     ****************************************/
    Route::get('/products/pinyin/{pinyin}', 'ProductsController@getProductsByPinyin');
    Route::get('/products/search', 'ProductsController@search');

    /****************************************
     * 1. 商品分类的资源路由，
     * 2. 商品的资源路由哦
     * 3. 购物车的资源路由
     ****************************************/
    Route::resource('/categories', 'CategoriesController', ['only' => ['index', 'show']]);
    Route::resource('/products', 'ProductsController', ['only' => ['index', 'show']]);
    Route::resource('/cars', 'CarsController');
});

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
    Route::post('/subscribe', 'UsersController@subscribe');
    Route::post('/desubscribe', 'UsersController@deSubscribe');

    /****************************************
     * 1. 修改密码页面
     * 2. 修改密码
     ****************************************/
    Route::get('/password', 'UsersController@showPasswordForm');
    Route::post('/password', 'UsersController@updatePassword');

    /****************************************
     * 1. 用户设置个人中心
     * 2. 修改用户头像
     * 3. 修改用户资料
     ****************************************/
    Route::get('/setting', 'UsersController@setting');
    Route::post('/upload/avatar', 'UsersController@uploadAvatar');
    Route::put('/update', 'UsersController@update');

    /****************************************
     * 1. 设置用户的默认收货地址
     * 2. 根据省份 id 获取城市列表
     * 3. 收货地址的资源路由
     ****************************************/
    Route::post('/addresses/default/{address}', 'AddressesController@setDefaultAddress');
    Route::get('/addresses/cities', 'AddressesController@getCities');
    Route::resource('/addresses', 'AddressesController');

    /****************************************
     * 1. 用户收藏商品的列表
     * 2. 收藏，取消收藏商品
     * 3. 单个订单的下单
     * 4. 订单的资源路由
     ****************************************/
    Route::get('/likes', 'LikesController@index');
    Route::match(['post', 'delete'], '/likes/{id}', 'LikesController@toggle');
    Route::post('/orders/single', 'OrdersController@single');
    Route::resource('/orders', 'OrdersController', ['only' => ['index', 'store', 'show']]);

    /****************************************
     * 1. 支付的显示页面
     * 2. 支付的处理
     ****************************************/
    Route::post('/pay/show', 'PaymentsController@index');
    Route::post('/pay/store', 'PaymentsController@pay');
});
/****************************************
 * 1. 用户付费！如果验证了[user.auth]，
 *    就会发生无限跳转，所以放在外面
 ****************************************/
Route::get('/user/pay/return', 'User\PaymentsController@payreturn');
Route::post('/user/pay/notify', 'User\PaymentsController@paynotify');


/****************************************
 * 后台相关的路由
 * 1. 用户登录界面
 * 2. 用户登录
 * 3. 注销登录
 ****************************************/
Route::get('/admin/login' ,'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Admin\Auth\LoginController@login');
Route::post('/admin/logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');
Route::middleware(['admin.auth', 'admin.permission'])->prefix('admin')->namespace('Admin')->group(function(){

    /****************************************
     * 1. 后台主页
     * 2. 主页显示的欢迎页面
     ****************************************/
    Route::get('/', 'HomeController@index');
    Route::get('/welcome', 'HomeController@welcome')->name('admin.welcome');

    /****************************************
     * 1. 改变商品的状态，上架 or 下架
     * 2. 商品图片的上传
     * 3. 商品详情的图片上传
     * 4. 根据图片的 id 删除图片
     ****************************************/
    Route::any('/products/change/alive/{product}', 'ProductsController@changeAlive');
    Route::post('/products/upload/images', 'ProductsController@upload');
    Route::post('/products/upload/detail', 'ProductsController@uploadDetailImage');
    Route::any('/products/delete/images', 'ProductsController@deleteImage');


    /****************************************
     * 1. 分类后台的管理路由
     * 2. 商品后台分类的管理路由
     * 3. 商品图片的后台管理路由
     ****************************************/
    Route::resource('/categories', 'CategoriesController');
    Route::resource('/products', 'ProductsController');
    Route::resource('/productImages', 'ProductImagesController', ['only' => ['index', 'destroy']]);

    /****************************************
     * 1. 用户后台的管理路由
     * 2. 管理员后台的管理路由
     * 3. 角色的后台管理路由
     ****************************************/
    Route::resource('/users', 'UsersController', ['only' => ['index']]);
    Route::resource('/admins', 'AdminsController');
    Route::resource('/roles', 'RolesController');
});