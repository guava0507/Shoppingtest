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
        
        if($way==4)
        {
           
            $time1 = $request->time1;
            $time2 =  $request->time2;
            if(($time1==null)or($time2==null))
            {
                return 'space';
            }
            $ctime1=explode('/',$time1);
            $ctime2=explode('/',$time2);
        
            $atime1=$ctime1[2]."-".$ctime1[1]."-".$ctime1[0];
            $atime2=$ctime2[2]."-".$ctime2[1]."-".$ctime2[0];
        }
        else
        {
            $keyword=$request->text;
        }
      // return $atime1;
       
       //return $time2;
        
    
        switch($way)
        {
            case 0:
                $ordershow=DB::table('orders')->select('orderId')->where('servername','=',"$keyword")->get();
            break;
            case 1:
                $ordershow=DB::table('orders')->select('orderId')->where('servername','=',"$keyword")->get();
            break;
            case 2:
                $ordershow=DB::table('orders')->select('orderId')->where('orderId','=',"$keyword")->get();
            break;
            case 3:
                $ordershow=DB::table('orderdetail')->select('orderId')->where('proname','=',"$keyword")->get();
            break;
            case 4:
                $ordershow=DB::select("select orderId from orders where createT between '$atime1' and '$atime2'");
                //$ordershow=DB::table('orderdetail')->select('orderId')->where('createT','between',"$atime1",'and',"$atime2")->get();
            break;
        }

        $view = view('adminsearchorder', compact('ordershow'))->renderSections()['resault'];
        return response()->json(['html' => $view]);
       // return $request;
    }
    public function detail($orderId)
    {
        $get=$orderId;
        $ordershow=DB::select("select od.*  FROM orderdetail od join orders o on od.orderId =  o.orderId  where od.orderId=$get");
        $ordertotal =DB::select("select SUM(total) stotal from orderdetail where orderId = $get UNION select status from orders where orderId=$get");
        $sale=DB::select("select sale from orders where orderId =$get");
        $saletotal=DB::select("select stotal from orderdetail where orderId=$get");
        // $ordershow = DB::select("SELECT DISTINCT od.*,o.status FROM `$get` od join orders o on od.name = o.servername");
        // $ordertotal = DB::select("SELECT SUM(total) stotal FROM `$get` UNION SELECT status from orders where orderId = '$get'");
       // return $ordertotal;
        return view('orderdetail',compact('ordershow','ordertotal','sale','saletotal'));

        return $orderId;
    }
}
