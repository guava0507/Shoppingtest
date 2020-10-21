<?php

namespace App\Http\Controllers;

session_start();
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WelController extends Controller
{

    //
    public function welcome()
    {

        
        $user = Auth::user();
        $products = DB::table('products')->where('status', '=', '上架')->get();
        $productype = DB::table('productype')->get();
        if ($user == "") {
            return view('welcome', compact('products', 'productype'));
        } else {
            $username = $user->name;
            
            $buymoney=DB::select("select total from buymoney where user='$username' order by createT DESC limit 1");
           
            return view('welcome', compact('products', 'productype', 'buymoney'));
        }

    }

}
