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

// トッページ無効化
Route::get('/', 'HomeController@top')->name('top');

// ゲストユーザー用
Auth::routes();

// ダッシュボード
Route::get('/dashboard', 'HomeController@index')->name('dashboard');

// Voyager
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
