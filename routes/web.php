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
    // github登录
    Route::get('/auth/github', 'AuthLoginController@redirectToGithub');

    // 第三方登录统一回调
    Route::get('/auth/callback', 'AuthLoginController@handleProviderCallback');
});




Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');