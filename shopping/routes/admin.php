<?php

Route::get('/',function(){
    return view ('admin');

});

Route::post('/management','adminlogin@check');

Route::post('/usermanage','adminlogin@editmanage');

//帳號管理
Route::get('edit/{username}','adminedit@edituser');
Route::get('search/{username}','adminorder@search');
Route::post('/ban','adminban@ban');

Route::post('/userdatach','adminedit@userchange');
Route::post('/ordersearch','adminordersearch@search');
Route::post('/searchway','adminordersearch@searchway');
Route::post('/ordershow','adminordersearch@show');
Route::get('orderdetail/{orderId}','adminordersearch@detail');
//商品類別
Route::post('/productype','adminproductype@type');
Route::post('/typechange','adminproductype@change');

//庫存管理
Route::post('/productmanage','adminproductmanage@choose');
Route::get('/addproduct','adminproductmanage@addproduct');
Route::post('/addfinish','adminproductmanage@addfinish');
//會員訂單
Route::post('/adminshoworder','adminorder@ordershow');