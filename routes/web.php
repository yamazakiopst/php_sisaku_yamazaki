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

//メニュー
Route::get('menu', function () {
    return view('menu.user');
})->name('menu.user');

//ログイン
Route::group(['prefix' => 'login', 'middleware' => 'guest'], function () {
    Route::get('index', 'LoginController@index')->name('login.index');
    Route::post('auth', 'LoginController@auth')->name('login.auth');
});

//ログアウト
Route::get('logout', 'LoginController@logout')->name('logout')->middleware('auth');

//会員登録
Route::group(['prefix' => 'member', 'middleware' => 'guest'], function () {
    Route::get('index', 'MemberRegistController@index')->name('member.index');
    Route::post('confirm', 'MemberRegistController@confirm')->name('member.confirm');
    Route::post('regist', 'MemberRegistController@regist')->name('member.regist');
});

//どのルートにも一致しない場合
Route::fallback(function () {
    return redirect(route('menu.user'));
});
