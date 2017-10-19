<?php

// home page
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

// user auth
Auth::routes();
Route::group(['namespace' => 'Auth'], function(){
    // 激活用户账户
    Route::get('/register/active/{token}', 'UserController@activeAccount');
    // 重新发送激活邮件链接
    Route::get('/register/again/send/{id}', 'UserController@sendActiveMail');

    // 第三方登录
    Route::get('/auth/github', 'AuthLoginController@redirectToGithub');
    Route::get('/auth/github/callback', 'AuthLoginController@handleGithubCallback');
    Route::get('/auth/qq', 'AuthLoginController@redirectToQQ');
    Route::get('/auth/qq/callback', 'AuthLoginController@handleQQCallback');
    Route::get('/auth/weibo', 'AuthLoginController@redirectToWeibo');
    Route::get('/auth/weibo/callback', 'AuthLoginController@handleWeiboCallback');


});


/**********  admin  **********/
Route::get('admin/login' ,'Admin\Auth\LoginController@showLoginForm')->name('admin.signin');
Route::post('admin/login', 'Admin\Auth\LoginController@login');
Route::middleware([])->prefix('admin')->namespace('Admin')->group(function(){

    Route::get('/', 'HomeController@index');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');

});