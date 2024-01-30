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

//新增的 resource 方法将遵从 RESTful 架构为用户资源生成路由。该方法接收两个参数，第一个参数为资源名称，第二个参数为控制器名称。
Route::resource('users', 'UsersController');
/*
Route::get('/users', 'UsersController@index')->name('users.index');
Route::get('/users/create', 'UsersController@create')->name('users.create');
Route::get('/users/{user}', 'UsersController@show')->name('users.show');
Route::post('/users', 'UsersController@store')->name('users.store');
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');
*/

Route::get('login', 'SessionsController@create')->name('login');//显示登录页面
Route::post('login', 'SessionsController@store')->name('login');//创建新会话（登录）
Route::delete('logout', 'SessionsController@destroy')->name('logout');//销毁会话（退出登录）


//使用范例
//Route::group([
//    'middleware' => ['auth'], // 为这个路由组应用 auth 中间件，确保只有经过身份验证的用户才能访问这些路由
//    'namespace' => 'App\Http\Controllers\Backend', // 设置控制器的命名空间，这样在这个组内的所有路由都会自动查找指定命名空间下的控制器
//    'prefix' => 'admin', // 设置路由前缀，例如访问 admin/users 将映射到 Users 控制器
//], function () {
//    Route::get('/', 'DashboardController@index')->name('admin.dashboard'); // 访问 /admin，映射到 DashboardController 的 index 方法
//    Route::resource('users', 'UserController'); // 创建一个资源控制器，所有路由带有前缀 /admin，例如：/admin/users/create 等
//});
Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', \App\Http\Controllers\UsersController::class)->except([
        'show', 'create', 'store',
    ]);
});

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
