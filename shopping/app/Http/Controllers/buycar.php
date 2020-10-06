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
             $carlistt=DB::table('buycar')->select(DB::raw("SUM(total) as stotal"))->where('name','=',"$username")->get();
            
           return view('buycar',compact('carlist','carlistt'));
          // return "$username";
         //return $carlistt;
        }
        else
        {
            return redirect('login')->with('alert','請先登入帳號');
        }
    }
    public function prolist(Request $request)
    {
        $t=$request->list;
        //return $t;

         return "應付金額：$t";
    }

    public function finish(Request $request)
    {
        
        $fname= $request['changename'];
        $fquantity=$request['changeq'];
        $fprice=$request['price'];
        if($fname==0)
        {
            return "nothing";
        }
        else
        {
            for($i=0;$i<count($fname);$i++)
            {
            $show[] = $fprice[$i]*$fquantity[$i];
            }
            $test=implode(',',$fname);
             return $test;
            
        }
    }
        
    public function qchange(Request $request)
    {
        
        $cquantity=$request['changeq'];
        $cprice=$request['price'];
        for($i=0;$i<count($cname);$i++)
        {
        $show[] = $cprice[$i]*$cquantity[$i];
        }
         return $show;
    }
    public function addcar(Request $request)
    {
        if(Auth::check()){
            $proname=$request->pname;
            $proprice=$request->pprice;
            $probuy=$request->buynum;
            $user = Auth::user();
            $username=$user->name;
            $x=0;
            
            $selcheck=DB::select("select proname from buycar where name='$username'");
            $length=count($selcheck);
             foreach($selcheck as $check)
             {
                if(($check->proname)==$proname)
                {
                    DB::update("update buycar set quantity=quantity+$probuy ,total = quantity*proprice where (proname ='$proname')and (name='$username')");
                break;
                }
                if((($check->proname)!=$proname))
                {
                    $x++;
                    if($x==$length)
                    {
                    DB::insert("Insert into buycar(proname,proprice,quantity,total,name) values('$proname',$proprice,$probuy,($proprice*$probuy),'$username')");
                    break;
                    }
                }
             }
            DB::update("update products set stock=stock-$probuy where name='$proname'");
             return redirect('/');
            //return "$x.$length";
            
        }
        else
        {
            return redirect('login')->with('alert','請先登入帳號');
        }
       
    }
}
