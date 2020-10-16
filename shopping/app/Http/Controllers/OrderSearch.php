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
       
        //$ordershow = DB::table('orderdetail')->where('orderId','=',"$get")->get();
        $ordershow=DB::select("select od.*  FROM orderdetail od join orders o on od.orderId =  o.orderId  where od.orderId=$get");
        $ordertotal =DB::select("select SUM(total) stotal from orderdetail where orderId = $get UNION select status from orders where orderId=$get");
       //return $ordertotal;
        return view('orderdetail',compact('ordershow','ordertotal'));
       
    }
}
