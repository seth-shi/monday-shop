<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Mail\UserRegister;




Auth::routes();
Route::view('singin', 'auth.singin');

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




Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');