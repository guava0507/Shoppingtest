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

//會員訂單
Route::post('/adminshoworder','adminorder@ordershow');