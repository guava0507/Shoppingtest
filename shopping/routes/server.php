<?php

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/','WelController@welcome');

Route::post('/prosort','WelController@selProduct')->name('prosort');

Route::post('/category','WelController@selProduct')->name('category');

Route::get('/login/refereshcapcha','Auth\LoginController@refereshcapcha');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');