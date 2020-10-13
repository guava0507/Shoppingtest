<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminorder extends Controller
{
    //
    public function search($username)
    {

        $ordershow = DB::table('orders')->where('servername', '=', "$username")->get();
        return view('ordershow', compact('ordershow'));

    }
    public function ordershow(Request $request)
    {
        $get=$request->gethref;
        $ordershow = DB::select("SELECT DISTINCT od.*,o.status FROM `$get` od join orders o on od.name = o.servername");
        $ordertotal = DB::select("SELECT SUM(total) stotal FROM `$get` UNION SELECT status from orders where orderId = '$get'");
       // return $ordertotal;
        return view('orderdetail',compact('ordershow','ordertotal'));
    }
}
