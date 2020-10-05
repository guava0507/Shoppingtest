<?php


Route::get('/','WelController@welcome');
//商品排序 種類
Route::post('/prosort','ProductSort@selProduct')->name('prosort');
Route::post('/category','ProductSort@selProduct')->name('category');

//認證刷新
Route::get('/login/refereshcapcha','Auth\LoginController@refereshcapcha');

//商品詳細資料
Route::get('productd/{productd}','ProductDetail@product');

//購物車
Route::get('buycar','buycar@buycar');
//加入購物車
Route::post('/buycar','buycar@addcar')->name('buycar');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');