<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class OrderSearch extends Controller
{
    //
    public function orderdata(Request $request)
    {   
        $user = Auth::user();
        $username=$user->name;
        $orderdata=DB::table('orders')->select('orderId')->where('servername','=',"$username")->get();
        return view('orderdata',compact('orderdata'));
        //return $orderdata;

    }
    
    public function getorder(Request $request)
    {
        $user = Auth::user();
        $username=$user->name;
        $get=$request->gethref;
        $ordershow = DB::select("SELECT DISTINCT od.*,o.status FROM `orderdetail` od join orders o on od.name = o.servername");
        $ordertotal = DB::select("SELECT SUM(total) stotal FROM `orderdetail` UNION SELECT o.status from orders o join `orderdetail` od on o.orderId =  od.orderId");
       // return $ordertotal;
        return view('orderdetail',compact('ordershow','ordertotal'));
       
    }
}
