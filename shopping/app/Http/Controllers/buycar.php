<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class buycar extends Controller
{
    //

    public function buycar()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $username = $user->name;
            $carlist = DB::select("select proname,proprice,quantity,total from buycar where name ='$username' ");
            $carlistt = DB::table('buycar')->select(DB::raw("SUM(total) as stotal"))->where('name', '=', "$username")->get();

            return view('buycar', compact('carlist', 'carlistt'));
            // return "$username";
            //return $carlistt;
        } else {
            return redirect('login')->with('alert', '請先登入帳號');
        }
    }

    public function prolist(Request $request)
    {
        $t = $request->list;
        //return $t;

        return "應付金額：$t";
    }
//修改完成
    public function finish(Request $request)
    {
        $user = Auth::user();
        $username = $user->name;
        $fname = $request['changename'];
        $fquantity = $request['changeq'];
        $fprice = $request['price'];
        if ($fname == null) {
            DB::delete("delete from buycar where name ='$username'");
            return redirect('/');
        }
      
       DB::delete("delete from buycar where name = '$username'");
        for ($i = 0; $i < count($fname); $i++) {
            $show[] = $fprice[$i] * $fquantity[$i];
            DB::insert("insert into buycar (proname,proprice,quantity,total,name) values ('$fname[$i]',$fprice[$i],$fquantity[$i],$show[$i],'$username')");
        }
        return redirect('/');

    }

    public function qchange(Request $request)
    {
        $cproname = $request['proname'];
        $cquantity = $request['changeq'];
        $cprice = $request['price'];
        for ($i = 0; $i < count($cprice); $i++) {
            $checknum = DB::select("select stock,name from products");
            for ($j = 0; $j < count($checknum); $j++) {
                if ($cproname[$i] == $checknum[$j]->name) {
                    $checkquantity[$i] = $checknum[$j]->stock;
                }
            }

            if ($cquantity[$i] > $checkquantity[$i]) {

                return "此商品$cproname[$i]數量已超過庫存，請重新選擇數量";

            }
            $show[] = $cprice[$i] * $cquantity[$i];

        }
        return $show;
        //  return $checknum;

    }

    public function addcar(Request $request)
    {
        if (Auth::check()) {
            $proname = $request->pname;
            $proprice = $request->pprice;
            $probuy = $request->buynum;
            $user = Auth::user();
            $username = $user->name;
            $x = 0;
            $check = 1;
            $selcheck = DB::select("select proname from buycar where name='$username'");
            if ($selcheck == null) {
                // $check =  2;
                DB::insert("Insert into buycar(proname,proprice,quantity,total,name) values('$proname',$proprice,$probuy,($proprice*$probuy),'$username')");
            }
            $length = count($selcheck);
            foreach ($selcheck as $selchecks) {
                if (($selchecks->proname) == $proname) {
                    DB::update("update buycar set quantity=quantity+$probuy ,total = quantity*proprice where (proname ='$proname')and (name='$username')");
                    break;
                }
                if ((($selchecks->proname) != $proname)) {
                    $x++;
                    if ($x == $length) {
                        DB::insert("Insert into buycar(proname,proprice,quantity,total,name) values('$proname',$proprice,$probuy,($proprice*$probuy),'$username')");
                        break;
                    }
                }
            }

            DB::update("update products set stock=stock-$probuy where name='$proname'");
            return redirect('/');
           

        } else {
            return redirect('login')->with('alert', '請先登入帳號');
        }

    }
    public function sendpro(Request $request)
    {
      
        $chkaddress=$request->getaddress;
        $chkname=$request->getname;
       
        if((($chkaddress==null)or($chkname==null)))
        {
            return 12;
            return 1;
        }
        else
        {
            $user = Auth::user();
            $username = $user->name;
            
            $orderdate=date('Ymd',time());
            DB::insert("insert into orders (servername,createT) values ('$username',CURRENT_TIMESTAMP)");
             $neworder=DB::select("select id from orders order by id DESC limit 1");
             $order = $orderdate.$neworder[0]->id;
             
             DB::update("update orders set orderId = '$order' where servername = '$username' order by id DESC limit 1");
            // //  //return $order;
           
             $pronum = DB::table('buycar')->select('proname','proprice','quantity','total')->where('name','=',"$username")->get();
           // return $pronum[0]->proname;
             
           
            for($i=0;$i<count($pronum);$i++)
              {
                  $proname []=$pronum[$i]->proname;
                  $price[]=$pronum[$i]->proprice;
                  $quantity[]=$pronum[$i]->quantity;
                  $total[]=$price[$i]*$quantity[$i];
                  
                  DB::insert("insert into `orderdetail` (orderId,proname,price,quantity,total,`name`,address,createT) values ('$order','$proname[$i]',$price[$i],$quantity[$i],$total[$i],'$chkname','$chkaddress',CURRENT_TIMESTAMP)");
              }
             
           // return $neworder[0]->id;
           DB::delete("delete from buycar where name='$username'"); 
           $carlist=DB::select("select * from buycar");
           $carlistt = DB::table('buycar')->select(DB::raw("SUM(total) as stotal"))->where('name', '=', "$username")->get();
        //    //return redirect('/')->;
            //return $request;
           $view = view('buycar', compact('carlist','carlistt'))->renderSections()['clear'];
            return response()->json(['html' => $view]);
        }
        
       
       
    }
}
