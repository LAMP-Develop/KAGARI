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

// OAuth認証
Route::prefix('auth')->group(function () {
    // Google OAuth2.0
    Route::get('/{provider}', 'Auth\OAuthController@socialOAuth')->where('provider', 'google')->name('socialOAuth');
    Route::get('/{provider}/callback', 'Auth\OAuthController@handleProviderCallback')->where('provider', 'google')->name('oauthCallback');
});

// ダッシュボード内
Route::group(['prefix' => 'dashboard'], function () {
    // トップ
    Route::get('/', 'HomeController@index')->name('dashboard');
    // アカウント関連
    Route::group(['prefix' => 'account'], function () {
        Route::get('/addsite', 'AddSitesController@index')->middleware('analytics.properties')->name('addsite');
    });
});

// Voyager
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
