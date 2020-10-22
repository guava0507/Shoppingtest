<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class orderdeal extends Controller
{
    //
    public function goorder(Request $requst)
    {
        $orderdata = DB::table('orders')->get();
        return view('goorder', compact('orderdata'));
    }
    public function ordergo(Request $request)
    {
        $status = $request->t;
        $id = $request->x;
        $levelif = [];
        $levelmoney = [];
        $num = 0;
        
        if ($status == '出貨') {
            DB::update("update orders set status='已出貨' where orderId = $id");

            $to = DB::select("select stotal from orderdetail where orderId = '$id'");
            $ts = $to[0]->stotal;
            //  return $ts;
            $bo = DB::select("select total,user from buyrecord where user in (select servername from orders  where orderId = $id ) order by createT DESC limit 1");
            $bs = $bo[0]->total;
            // $br=$bo[0]->record;
            $bu = $bo[0]->user;
            //  return $bu;
    
            DB::insert("insert into buyrecord (user,record,total,createT) values ('$bu',$ts,$bs+$ts,CURRENT_TIMESTAMP)");

            $lcheck = DB::select("select total from buyrecord where user = '$bu' order by createT DESC limit 1");
            // return $lcheck;
            $ls = $lcheck[0]->total;
            $level = DB::table('level')->get();
            $jump = $level[0]->jump;
            for ($i = 0; $i < 5; $i++) {
                $levelmoney[$i] = $level[$i]->money;
                $levelif[$i] = $level[$i]->level;
            }
            //return $jump;
            if ($jump == 1) {
                for ($i = 0; $i < 5; $i++) {
                    if ($ls >= $levelmoney[$i]) {
                        $num++;
                    }
                }
                DB::update("update users set level =$num where name ='$bu'");
            } elseif ($jump == 0) {
                $ul = DB::select("select level from users where name = '$bu'");
                $oldlevel=$ul[0]->level;
                $ule = $ul[0]->level;
                switch ($ule) {
                    case 0:
                        if ($ls >= $levelmoney[1]) {
                            $num = $ule + 1;
                        } else {
                            $num = $ule;
                        }

                        break;
                    case 1:
                        if ($ls >= $levelmoney[2]) {
                            $num = $ule + 1;
                        } else {
                            $num = $ule;
                        }

                        break;
                    case 2:
                        if ($ls >= $levelmoney[3]) {
                            $num = $ule + 1;
                        } else {
                            $num = $ule;
                        }

                        break;
                    case 3:
                        if ($ls >= $levelmoney[4]) {
                            $num = $ule + 1;
                        } else {
                            $num = $ule;
                        }

                        break;
                    case 4:
                        if ($ls >= $levelmoney[5]) {
                            $num = $ule + 1;
                        } else {
                            $num = $ule;
                        }

                        break;
                    default:
                        $num = 5;
                }

                DB::update("update users set level =$num where name ='$bu'");

            }


        } elseif ($status == '取消出貨') {

            DB::update("update orders set status='未出貨' where orderId = $id");
            
        }

        $orderdata = DB::table('orders')->get();

        $view = view('goorder', compact('orderdata'))->renderSections()['go'];
        return response()->json(['html' => $view]);
        //return $request;
    }
}
