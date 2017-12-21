<?php

/**********  auth  **********/
Auth::routes();

Route::namespace('Auth')->group(function(){
    // account active link
    Route::get('/register/active/{token}', 'UserController@activeAccount');
    // again send active link
    Route::get('/register/again/send/{id}', 'UserController@sendActiveMail');

    // github,qq,weibo authorize login
    Route::get('/auth/github', 'AuthLoginController@redirectToGithub');
    Route::get('/auth/github/callback', 'AuthLoginController@handleGithubCallback');
    Route::get('/auth/qq', 'AuthLoginController@redirectToQQ');
    Route::get('/auth/qq/callback', 'AuthLoginController@handleQQCallback');
    Route::get('/auth/weibo', 'AuthLoginController@redirectToWeibo');
    Route::get('/auth/weibo/callback', 'AuthLoginController@handleWeiboCallback');
});

/**********  home  **********/
Route::get('/', 'Home\HomeController@index');

Route::prefix('home')->namespace('Home')->group(function(){
    Route::get('/', 'HomeController@index');

    Route::get('/products/pinyin/{pinyin}', 'ProductsController@getProductsByPinyin');
    Route::get('/products/search', 'ProductsController@search');

    Route::resource('/categories', 'CategoriesController', ['only' => ['index', 'show']]);
    Route::resource('/products', 'ProductsController', ['only' => ['index', 'show']]);
    Route::resource('/cars', 'CarsController');
});

/**********  user  **********/
Route::middleware(['user.auth'])->prefix('user')->namespace('User')->group(function(){

    Route::get('/', 'UsersController@index');

    Route::post('/subscribe', 'UsersController@subscribe');
    Route::post('/desubscribe', 'UsersController@deSubscribe');

    // user password setting
    Route::get('/password', 'UsersController@showPasswordForm');
    Route::post('/password', 'UsersController@updatePassword');

    // user information setting
    Route::get('/setting', 'UsersController@setting');
    Route::post('/upload/avatar', 'UsersController@uploadAvatar');
    Route::put('/update', 'UsersController@update');

    // user address setting
    Route::post('/addresses/default/{address}', 'AddressesController@setDefaultAddress');
    Route::get('/addresses/cities/{id}', 'AddressesController@getCities');
    Route::get('/addresses/region/{id}', 'AddressesController@getRegion');
    Route::resource('/addresses', 'AddressesController');

    // user products like, cancel like,
    Route::get('/likes', 'LikesController@index');
    Route::match(['post', 'delete'], '/likes/{id}', 'LikesController@toggle');

    // user order show and index
    Route::post('/orders/single', 'OrdersController@single');
    Route::resource('/orders', 'OrdersController', ['only' => ['index', 'store', 'show']]);

    // user payments
    Route::post('/pay/show', 'PaymentsController@index');
    Route::post('/pay/store', 'PaymentsController@pay');
});
// user payments !!! If [user.auth] is validated, infinite jumps will occur
Route::get('/user/pay/return', 'User\PaymentsController@payreturn');
Route::post('/user/pay/notify', 'User\PaymentsController@paynotify');


/**********  admin  **********/
Route::get('/admin/login' ,'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Admin\Auth\LoginController@login');
Route::post('/admin/logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');

Route::middleware(['admin.auth', 'admin.permission'])->prefix('admin')->namespace('Admin')->group(function(){

    // admin home page
    Route::get('/', 'HomeController@index');
    Route::get('/welcome', 'HomeController@welcome')->name('admin.welcome');

    // change product Alive or undercarriage
    Route::any('/products/change/alive/{product}', 'ProductsController@changeAlive');
    // product image and product list image upload
    Route::post('/products/upload/images', 'ProductsController@upload');
    Route::post('/products/upload/detail', 'ProductsController@uploadDetailImage');
    Route::any('/products/delete/images', 'ProductsController@deleteImage');


    Route::resource('/categories', 'CategoriesController');
    Route::resource('/products', 'ProductsController');

    Route::resource('/productImages', 'ProductImagesController', ['only' => ['index', 'destroy']]);
    Route::resource('/users', 'UsersController', ['only' => ['index']]);
    Route::resource('/admins', 'AdminsController');
    Route::resource('/roles', 'RolesController');
});