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
    Route::get('result', 'MemberRegistController@result')->name('member.result');
});

//商品検索
Route::group(['prefix' => 'product'], function () {
    Route::get('index', 'ProductController@index')->name('product.index');
    Route::get('search', 'ProductController@search')->name('product.search');
    Route::post('result', 'ProductController@result')->name('product.result');
    Route::get('detail/{id}', 'ProductController@detail')->name('product.detail');
    Route::post('add', 'ProductController@add')->name('product.add');
});

//お買い物かご
Route::group(['prefix' => 'cart'], function () {
    Route::get('index', 'CartController@index')->name('cart.index');
    Route::post('operate', 'CartController@operate')->name('cart.operate');
    Route::get('confirm', 'CartController@confirm')->name('cart.confirm');
    Route::post('order', 'CartController@order')->name('cart.order');
    Route::get('result', 'CartController@result')->name('cart.result');
});

//共通エラー
Route::get('error', function () {
    return view('common.error');
})->name('error');

Route::get('test', 'TestController@index');
Route::get('del', 'TestController@del');
/*
//どのルートにも一致しない場合
Route::fallback(function () {
    return redirect(route('menu.user'));
});
*/
