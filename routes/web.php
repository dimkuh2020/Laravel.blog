<?php
//!!! в файле app/Providers/RoutesServiceProvider.php добавляем namespace!!!//

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function(){ // группа роутов + middleware (или каждый по совему Route:get('/admin', 'Admin\MainController@index')->name('admin.index'); )
    Route::get('/', 'MainController@index')->name('admin.index');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/tags', 'TagController');
    Route::resource('/posts', 'PostController');
});

Route::group(['middleware' => 'guest'], function(){ // по middleware заходят только неавторизованные гости
    Route::get('/register', 'UserController@create')->name('register.create');
    Route::post('/register', 'UserController@store')->name('register.store');
    Route::get('/login', 'UserController@loginForm')->name('login.create');
    Route::post('/login', 'UserController@login')->name('login');
});


Route::get('/logout', 'UserController@logout')->name('logout')->middleware('auth'); // отдельный middleware для зарегестрированых пользователей



