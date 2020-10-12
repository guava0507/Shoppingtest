<?php


Route::get('/','WelController@welcome');
//商品排序 種類
Route::post('/prosort','ProductSort@selProduct')->name('prosort');
Route::post('/category','ProductSort@selProduct')->name('category');

//加入購物車
Route::post('/buycar','buycar@addcar')->name('buycar');
//購物車
Route::post('/prolist','buycar@prolist');
Route::post('/qchange','buycar@qchange');
Route::post('/editfinish','buycar@finish');
Route::get('buycar','buycar@buycar');
Route::post('/send','buycar@sendpro');
//認證刷新
Route::get('/login/refereshcapcha','Auth\LoginController@refereshcapcha');

//修改個人資料
Route::post('/edit','Edituser@userdata');
Route::post('/passcheck','Edituser@passcheck');
Route::post('/useredit','Edituser@chooseedit');

//查詢訂單
Route::post('/orderdata','OrderSearch@orderdata');
Route::post('/getorder','OrderSearch@getorder');
//商品詳細資料
Route::get('productd/{productd}','ProductDetail@product');





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');