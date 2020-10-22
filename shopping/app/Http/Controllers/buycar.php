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
            $levels = DB::table('users')->select('level')->where('name', '=', "$username")->get();
            $level = $levels[0]->level;
            //return $level;
            $usemoney = DB::select("select total from buymoney where user='$username' order by createT DESC limit 1");
            $carlist = DB::select("select proname,proprice,quantity,total from buycar where name ='$username' ");
            $carlistt = DB::table('buycar')->select(DB::raw("SUM(total) as stotal"))->where('name', '=', "$username")->get();
            $sale1 = DB::table('sale')->where('type', '=', '1')->where('level', '<=', "$level")->get();
            $sale2 = DB::table('sale')->where('type', '=', '2')->where('level', '<=', "$level")->get();
            return view('buycar', compact('carlist', 'carlistt', 'sale1', 'sale2', 'usemoney'));
            // return "$username";
            //return $carlistt;
        } else {
            return redirect('login')->with('alert', '請先登入帳號');
        }
    }
    public function weladd(Request $request)
    {

        $name = $request->name;
        $price = $request->price;
        $num = $request->num;
        $id = $request->id;
        $user = Auth::user();
        $username = $user->name;

        // return $request;
        if (Auth::check()) {

            $check = DB::table('buycar')->select('proname')->where('proname', '=', "$name")->where('name', '=', "$username")->get();

            if (count($check) > 0) {
                DB::update("update buycar set quantity=quantity+$num,total=quantity*proprice where proname='$name' and name='$username'");
            } else {

                DB::insert("insert into buycar (proname,proprice,quantity,total,name) values ('$name',$price,'$num',$num*$price,'$username')");
            }
            return $request;
        } else {
            return 'login';
        }
    }
    public function prolist(Request $request)
    {
        $user = Auth::user();
        $username = $user->name;

        $delpro = $request->delname;
        $levels = DB::table('users')->select('level')->where('name', '=', "$username")->get();
        $level = $levels[0]->level;

        if (isset($delpro)) {

            for ($i = 0; $i < count($delpro); $i++) {
                DB::delete("delete from buycar where  proname='$delpro[$i]' and name ='$username'");
            }
            $usemoney = DB::select("select total from buymoney where user='$username' order by createT DESC limit 1");
            $carlist = DB::table('buycar')->select('proname', 'proprice', 'quantity', 'total')->where('name', '=', $username)->get();
            $carlistt = DB::table('buycar')->select(DB::raw("SUM(total) as stotal"))->where('name', '=', "$username")->get();
            $sale1 = DB::table('sale')->where('type', '=', '1')->where('level', '<=', "$level")->get();
            $sale2 = DB::table('sale')->where('type', '=', '2')->where('level', '<=', "$level")->get();
            $view = view('buycar', compact('carlist', 'carlistt', 'sale1', 'sale2', 'usemoney'))->renderSections()['clear'];
            return response()->json(['html' => $view]);
        } else {
            return "nothing";
        }

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
            return redirect('/');

        } else {
            return redirect('login')->with('alert', '請先登入帳號');
        }

    }
    public function buysale(Request $request)
    {
        $salec = $request->sale;
        $user = Auth::user();
        $username = $user->name;
        $levels = DB::table('users')->select('level')->where('name', '=', "$username")->get();
        $level = $levels[0]->level;
        $usemoney = DB::select("select total from buymoney where user='$username' order by createT DESC limit 1");
        $sale1 = DB::table('sale')->where('type', '=', '1')->where('level', '<=', "$level")->get();
        $sale2 = DB::table('sale')->where('type', '=', '2')->where('level', '<=', "$level")->get();
        $carlist = DB::select("select proname,proprice,quantity,total from buycar where name ='$username' ");
        $tcarlist = DB::table('buycar')->select(DB::raw("SUM(total) as stotal"))->where('name', '=', "$username")->get();

        $total = $tcarlist[0]->stotal;

        if ($salec != 'x') {

            $select = DB::table('sale')->where('saleId', '=', "$salec")->get();

            $type = $select[0]->type;

            $money = $select[0]->money;
            // return $total;

            if (($type == 1) and ($total >= $money)) {
                $sale = $select[0]->sale;
                $carlistt = DB::select("select floor(SUM(total)*0.$sale) as stotal from buycar where name ='$username'");
            } elseif (($type == 2) and ($total >= $money)) {
                $buymoney = $select[0]->sale;
                $carlistt = DB::table('buycar')->select(DB::raw("SUM(total) as stotal"))->where('name', '=', "$username")->get();
            } else {
                $carlistt = DB::table('buycar')->select(DB::raw("SUM(total) as stotal"))->where('name', '=', "$username")->get();
            }
        } else {

            $carlistt = DB::table('buycar')->select(DB::raw("SUM(total) as stotal"))->where('name', '=', "$username")->get();
        }

        $view = view('buycar', compact('carlist', 'carlistt', 'sale1', 'sale2', 'usemoney'))->renderSections()['clear'];
        return response()->json(['html' => $view]);

    }
    public function usemoney(Request $request)
    {
        $salec = $request->sale;
        $box = $request->x;
        $user = Auth::user();
        $username = $user->name;
        $levels = DB::table('users')->select('level')->where('name', '=', "$username")->get();
        $level = $levels[0]->level;
        $usemoney = DB::select("select total from buymoney where user='$username' order by createT DESC limit 1");
        $sale1 = DB::table('sale')->where('type', '=', '1')->where('level', '<=', "$level")->get();
        $sale2 = DB::table('sale')->where('type', '=', '2')->where('level', '<=', "$level")->get();
        $carlist = DB::select("select proname,proprice,quantity,total from buycar where name ='$username' ");
        $tcarlist = DB::table('buycar')->select(DB::raw("SUM(total) as stotal"))->where('name', '=', "$username")->get();
        $total = $tcarlist[0]->stotal;
        if ($box == 'true') {
            $use = $usemoney[0]->total;
            if ($use <= $total) {
                $carlistt = DB::table('buycar')->select(DB::raw("(SUM(total)-$use) as stotal"))->where('name', '=', "$username")->get();
            }
            else
            {
                $carlistt = DB::table('buycar')->select(DB::raw("(SUM(total)=0) as stotal"))->where('name', '=', "$username")->get();
            }

        } else {
            if ($salec != 'x') {

                $select = DB::table('sale')->where('saleId', '=', "$salec")->get();

                $type = $select[0]->type;

                $money = $select[0]->money;
                // return $total;

                if (($type == 1) and ($total >= $money)) {
                    $sale = $select[0]->sale;
                    $carlistt = DB::select("select floor(SUM(total)*0.$sale) as stotal from buycar where name ='$username'");
                } elseif (($type == 2) and ($total >= $money)) {
                    $buymoney = $select[0]->sale;
                    $carlistt = DB::table('buycar')->select(DB::raw("SUM(total) as stotal"))->where('name', '=', "$username")->get();
                    //     $to = DB::select("select total from buymoney where user='$username' order by createT DESC limit 1");
                    // $total = $to[0]->total;
                    // DB::insert("insert into buymoney (user,record,total,createT) values ('$username',$buymoney,$total+$buymoney,CURRENT_TIMESTAMP)");
                } else {
                    $carlistt = DB::table('buycar')->select(DB::raw("SUM(total) as stotal"))->where('name', '=', "$username")->get();
                }
            } else {

                $carlistt = DB::table('buycar')->select(DB::raw("SUM(total) as stotal"))->where('name', '=', "$username")->get();
            }

        }
        $view = view('buycar', compact('carlist', 'carlistt', 'sale1', 'sale2', 'usemoney'))->renderSections()['clear'];
        return response()->json(['html' => $view]);

    }
    public function sendpro(Request $request)
    {

        $stotal = $request->total;
        $sale = $request->sale;
        $chkaddress = $request->getaddress;
        $chkname = $request->getname;
        $chkquantity = $request->getquantity;
        $box = $request->box;
        if ((($chkaddress == null) or ($chkname == null))) {
            return "space";
        } else {
            $user = Auth::user();
            $username = $user->name;
            $levels = DB::table('users')->select('level')->where('name', '=', "$username")->get();
            $level = $levels[0]->level;
            $tmptotal= DB::table('buycar')->select(DB::raw("SUM(total) as stotal"))->where('name', '=', "$username")->get();
            $tt=$tmptotal[0]->stotal;
            $gap=$tt-$stotal;
           // return $tt-$stotal;
       
            $orderdate = date('Ymd', time());

            if($box ==='true')
            {
                $sale="使用購物金".$gap."元";
                $to = DB::select("select total from buymoney where user='$username' order by createT DESC limit 1");
                $ts = $to[0]->total;
                DB::insert("insert into buymoney (user,record,total,createT) values ('$username',-$gap,$ts+(-$gap),CURRENT_TIMESTAMP)");
            } 
            
            
            DB::insert("insert into orders (servername,createT,sale) values ('$username',CURRENT_TIMESTAMP,'$sale')");
            $neworder = DB::select("select id from orders order by id DESC limit 1");
            $order = $orderdate . $neworder[0]->id;

            DB::update("update orders set orderId = '$order' where servername = '$username' order by id DESC limit 1");
            // //  //return $order;
            $pronum = DB::table('buycar')->select('proname', 'proprice', 'quantity', 'total')->where('name', '=', "$username")->get();
            // return $pronum[0]->proname;
            //return "test";
            for ($i = 0; $i < count($pronum); $i++) {
                $proname[] = $pronum[$i]->proname;
                $price[] = $pronum[$i]->proprice;
                $quantity[] = $pronum[$i]->quantity;
                $total[] = $quantity[$i] * $price[$i];

                DB::insert("insert into `orderdetail` (orderId,proname,price,quantity,total,`name`,address,createT,stotal) values ('$order','$proname[$i]',$price[$i],$quantity[$i],$total[$i],'$chkname','$chkaddress',CURRENT_TIMESTAMP,$stotal)");
                DB::update("update products set stock=stock-$quantity[$i] where name = '$proname[$i]'");
            }
            // return $neworder[0]->id;
            //return "test";
           
             //return $ts;
             
            //DB::insert("insert into buymoney (user,record,total,createT) values ('$username',-$gap,$ts+(-$gap),CURRENT_TIMESTAMP)");
            //return "x";
            DB::delete("delete from buycar where name='$username'");
            $carlist = DB::select("select * from buycar where name='$username'");
            $carlistt = DB::table('buycar')->select(DB::raw("SUM(total) as stotal"))->where('name', '=', "$username")->get();
            $sale1 = DB::table('sale')->where('type', '=', '1')->where('level', '<=', "$level")->get();
            $sale2 = DB::table('sale')->where('type', '=', '2')->where('level', '<=', "$level")->get();
            $usemoney = DB::select("select total from buymoney where user='$username' order by createT DESC limit 1");
            //    //return redirect('/')->;
            //return $request;
            $view = view('buycar', compact('carlist', 'carlistt', 'sale1', 'sale2','usemoney'))->renderSections()['clear'];
            return response()->json(['html' => $view]);
        }

    }
}
