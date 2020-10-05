<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class buycar extends Controller
{
    //
   
    public function buycar()
    {
        if(Auth::check()){
            $user = Auth::user();
            $username=$user->name;
             $carlist=DB::select("select proname,proprice,quantity,total from buycar where name ='$username' ");
             //$carlistt=DB::table('buycar')->select(DB::raw("SUM(total)"))->where('name','=',"$username")->get();
             $carlistt=DB::select("select SUM(total) from buycar where name ='$username'");
             
          // $carlist=DB::table('buycar')->select('proname','proprice','quantity','total',DB::raw("SUM(total) as stotal"))->where('name','=',"$username")->groupBy('proname','proprice','quantity','total')->get();
           return view('buycar',compact('carlist','carlistt'));
          // return "$username";
        }
        else
        {
            return redirect('login')->with('alert','請先登入帳號');
        }
    }
    public function addcar(Request $request)
    {
        if(Auth::check()){
            $proname=$request->pname;
            $proprice=$request->pprice;
            $probuy=$request->buynum;
           
            $user = Auth::user();
            $username=$user->name;
            DB::insert("Insert into buycar(proname,proprice,quantity,total,name) values('$proname',$proprice,$probuy,$proprice*$probuy,'$username')");
            DB::update("update products set stock=stock-$probuy where name='$proname'");
            
            return redirect('/');
            //return view('buycar');
            //return "$username";
        }
        else
        {
            return redirect('login')->with('alert','請先登入帳號');
        }
       
    }
}
