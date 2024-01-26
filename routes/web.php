<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});

//使用name()方法为路由添加别名
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');
Route::get('/signup', 'UsersController@create')->name('signup');
Route::resource('users', 'UsersController');
//Route::get('/cache', function () {
//    return cache('key');
//});
//定义限流器
//Route::middleware(['throttle:api'])->group(function () {
//    Route::post('/audio', function () {
//        // ...
//    });
//
//    Route::post('/video', function () {
//        // ...
//    });
//});
