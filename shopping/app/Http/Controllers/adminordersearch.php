<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class adminordersearch extends Controller
{
    //
    public function search(Request $request){
        
        return view('adminsearchorder');

    }
}
