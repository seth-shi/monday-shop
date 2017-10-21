<?php

// home page
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

// user auth
Auth::routes();
Route::group(['namespace' => 'Auth'], function(){
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

    Route::get('/', 'HomeController@index');
    Route::get('/welcome', 'HomeController@welcome')->name('admin.welcome');


    Route::resource('categorys', 'CategoryController');
    // Route::resource('categorys', 'CategoryController', ['only' => ['index', 'show']]);
});