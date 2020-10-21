<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class orderdeal extends Controller
{
    //
    public function goorder(Request $requst)
    {
        $orderdata=DB::table('orders')->get();
        return view('goorder',compact('orderdata'));
    }
    public function ordergo(Request $request)
    {
        $status=$request->t;
        $id = $request->x;
        
        if($status=='未出貨')
        {
            DB::update("update orders set status='已出貨' where orderId = $id");
        
        }
        elseif($status=='已出貨')
        {
            
            DB::update("update orders set status='未出貨' where orderId = $id");
          
        }
        
        $orderdata=DB::table('orders')->get();
       
        $view = view('goorder',compact('orderdata'))->renderSections()['go'];
        return response()->json(['html' => $view]);
        //return $request;
    }
}
