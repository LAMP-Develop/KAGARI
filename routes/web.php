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
        Route::get('/', 'UserController@index')->name('account');
        // 退会フォーム
        Route::view('/delete', 'auth.delete')->name('delete');
        // サイト追加
        Route::group(['prefix' => 'addsite'], function () {
            Route::get('/', 'AddSitesController@index')->middleware('analytics')->name('addsite');
            // プラン選択
            Route::group(['prefix' => 'plan'], function () {
                Route::get('/', 'AddSitesController@plan')->middleware('webmaster')->name('plan');
                // 支払い
                Route::post('/payment', 'PaymentController@index')->name('payment');
                // プラン登録・支払い完了
                Route::post('/payment/done', 'PaymentController@done')->name('payment-done');
            });
        });
    });
});

// Voyager
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
