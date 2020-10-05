<?php

namespace App\Http\Controllers;

session_start();
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class WelController extends Controller
{

    //
    public function welcome()
    {
        $products = DB::table('products')->get();

        return view('welcome')->with('products', $products);

    }
    
  
}
