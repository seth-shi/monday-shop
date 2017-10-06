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

Route::get('/', function () {
    return view('welcome');
});


/******************** page ********************/
Route::get('/home', function(){
    return view('auth.register');
});


/******************** 登录注册 ********************/
Route::get('login', 'Auth\LoginController@create');
Route::post('login', 'Auth\LoginController@store');

Route::get('register', 'Auth\RegisterController@create');
Route::post('register', 'Auth\RegisterController@store');