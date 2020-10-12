<?php

Route::get('/',function(){
    return view ('admin');

});

Route::post('/management','adminlogin@check');

Route::post('/usermanage','adminlogin@editmanage');