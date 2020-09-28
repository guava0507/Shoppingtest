<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login/refereshcapcha','Auth\LoginController@refereshcapcha');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');