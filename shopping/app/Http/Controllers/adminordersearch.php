<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class adminordersearch extends Controller
{
    //
    public function search(Request $request){
        
        $ordershow = DB::table('orders')->select('orderId')->get();
        return view('adminsearchorder',compact('ordershow'));

    }
    public function searchway(Request $request)
    {
        return $request;
    }
    public function show(Request $request)
    {
        $way=$request->way;
        $keyword=$request->text;
        if($way==0)
        {
            $way=1;
        }
        if($way==1)
        {
            $ordershow=DB::table('orders')->select('orderId')->where('servername','=',"$keyword")->get();
        }
        elseif($way==2)
        {
            $ordershow=DB::table('orders')->select('orderId')->where('orderId','=',"$keyword")->get();
        }
        elseif($way==3)
        {
            $ordershow=DB::table('orders')->select('orderId')->where('servername','=',"$keyword")->get();

        }
        //return $keyword;
        $view = view('adminsearchorder', compact('ordershow'))->renderSections()['resault'];
        return response()->json(['html' => $view]);
       // return $request;
    }
    public function detail($orderId)
    {
        $get=$orderId;
        $ordershow = DB::select("SELECT DISTINCT od.*,o.status FROM `$get` od join orders o on od.name = o.servername");
        $ordertotal = DB::select("SELECT SUM(total) stotal FROM `$get` UNION SELECT status from orders where orderId = '$get'");
       // return $ordertotal;
        return view('orderdetail',compact('ordershow','ordertotal'));

        return $orderId;
    }
}
