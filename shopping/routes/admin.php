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
Route::post('/typedel','adminproductype@typedel');
//庫存管理
Route::post('/productmanage','adminproductmanage@choose');
Route::get('/addproduct','adminproductmanage@addproduct');

//商品情形
Route::post('/productotal','adminproductmanage@productotal');
Route::post('/addfinish','adminproductmanage@addfinish');
Route::post('/changestatus','adminproductmanage@changestatus');
Route::post('/formshow','adminproductmanage@formshow');
Route::post('/proeditOK','adminproductmanage@editOK');
Route::post('/categorychange','adminproductmanage@catechoose');
//會員訂單
Route::post('/adminshoworder','adminorder@ordershow');

//折扣優惠
Route::post('/sale','adminsale@sale');
Route::post('/salelist','adminsale@salelist');
Route::post('/moneyfree',function(){
return view('moneyfree');
});
Route::post('/moneysale',function(){
    return view('moneysale');
});
Route::post('/inmoneysale','adminsale@moneysale');
Route::post('/inmoneyfree','adminsale@moneyfree');

Route::post('/saledel','adminsale@saledel');
Route::post('/saleedit','adminsale@saleedit');

Route::post('/levelset','adminlevel@levelset');
Route::post('/levelfinish','adminlevel@levelfinish');