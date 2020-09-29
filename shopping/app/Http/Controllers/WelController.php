<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class WelController extends Controller
{
    //
    public function welcome()
    {
        
        $products = DB::table('products')->get();
        
        return view('welcome')->with('products', $products);
    }
}
