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

//判斷網域登入
Route::domain('admin.shopping.com')->group(__DIR__.'/admin.php');

Route::domain('server.shopping.com')->group(__DIR__.'/server.php');


