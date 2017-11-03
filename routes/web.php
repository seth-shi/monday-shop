<?php

// home page
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

// user auth
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


/**********  admin  **********/
Route::get('/admin/login' ,'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Admin\Auth\LoginController@login');
Route::post('/admin/logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');


Route::middleware(['admin.auth'])->prefix('admin')->namespace('Admin')->group(function(){

    // admin home page
    Route::get('/', 'HomeController@index');
    Route::get('/welcome', 'HomeController@welcome')->name('admin.welcome');


    Route::resource('categories', 'CategoryController');
    // change product Alive or undercarriage
    Route::any('products/change/alive/{product}', 'ProductController@changeAlive');
    // product image and product list image upload
    Route::post('products/upload/images', 'ProductController@upload');
    Route::post('products/upload/detail', 'ProductController@uploadDetailImage');
    Route::any('products/delete/images', 'ProductController@deleteImage');

    Route::resource('products', 'ProductController');
    Route::resource('productImages', 'ProductImagesController', ['only' => ['index', 'destroy']]);
    Route::resource('users', 'UsersController', ['only' => ['index']]);
    Route::resource('admins', 'AdminsController');
});