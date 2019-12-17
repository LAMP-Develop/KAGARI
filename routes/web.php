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
        // アカウント情報編集
        Route::get('/edit', 'UserController@account_form')->name('edit');
        Route::post('/edit-data', 'AjaxController@edit_account')->name('edit-ajax');
        // 退会フォーム
        Route::view('/delete', 'auth.delete')->name('delete');

        // サイト編集
        Route::group(['prefix' => 'sites'], function () {
            Route::get('/edit/{AddSites}', 'AddSitesController@edit', function ($sites) {
                return $sites;
            })->name('sites-edit');
        });

        // サイト追加
        Route::group(['prefix' => 'addsite'], function () {
            Route::get('/', 'AddSitesController@index')->middleware('analytics.properties')->name('addsite');

            // プラン選択
            Route::group(['prefix' => 'plan'], function () {
                Route::post('/', 'AddSitesController@plan')->middleware('webmaster')->name('plan');
                // 支払い
                Route::post('/payment', 'PaymentController@index')->name('payment');
                // プラン登録・支払い完了
                Route::post('/payment/done', 'PaymentController@done')->name('payment-done');
            });
        });
    });
});

// レポート系
Route::group(['prefix' => 'report'], function () {
    Route::get('/{AddSites}', 'ReportController@index', function ($sites) {
        return $sites;
    })->middleware('analytics.reporting')->name('ga-report');
    Route::get('/users/{AddSites}', 'ReportController@index', function ($sites) {
        return $sites;
    })->middleware('analytics.reporting')->name('ga-user');
    Route::get('/inflow/{AddSites}', 'ReportController@index', function ($sites) {
        return $sites;
    })->middleware('analytics.reporting')->name('ga-inflow');
    Route::get('/action/{AddSites}', 'ReportController@index', function ($sites) {
        return $sites;
    })->middleware('analytics.reporting')->name('ga-action');
    Route::get('/conversion/{AddSites}', 'ReportController@index', function ($sites) {
        return $sites;
    })->middleware('analytics.reporting')->name('ga-conversion');
    Route::get('/ad/{AddSites}', 'ReportController@index', function ($sites) {
        return $sites;
    })->middleware('analytics.reporting')->name('ga-ad');
    // pdf
    Route::get('/{AddSites}/pdf', 'PdfController@index', function ($sites) {
        return $sites;
    })->middleware('analytics.reporting')->name('ga-pdf');
});

// SEO解析系
Route::group(['prefix' => 'seo'], function () {
    Route::get('/{AddSites}', 'SeoController@index', function ($sites) {
        return $sites;
    })->middleware('webmaster')->name('seo-report');
});

// Ajax
Route::post('/seo-detail/{AddSites}', 'AjaxController@get_seo_detail', function ($sites) { // 個別ページのSEO
    return $sites;
});
Route::post('/seo-page-kyes/{AddSites}', 'AjaxController@get_seo_kyes', function ($sites) { // SCのキーワード取得
    return $sites;
});
Route::post('/ga-all/{AddSites}', 'AjaxController@get_ga_all', function ($sites) { // GAの全データ
    return $sites;
})->middleware('analytics.reporting');
Route::post('/sc-all/{AddSites}', 'AjaxController@get_sc_all', function ($sites) { // SCの全データ
    return $sites;
});
Route::post('/send-flag', 'AjaxController@set_send_flag'); // PDF送付のフラグ

// Voyager
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
