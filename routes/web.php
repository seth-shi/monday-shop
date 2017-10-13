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



Route::get('/user/success', function(){
    return view('home');
});



Auth::routes();
/**********  用户邮件验证  **********/
Route::get('register/active/{token}', 'Auth\UserController@activeAccount');



Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');