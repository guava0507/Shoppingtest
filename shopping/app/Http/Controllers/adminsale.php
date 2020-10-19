<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
;
class adminsale extends Controller
{
    //
    public function  sale(){
        return view('sale');
    }
    public function moneysale(Request $request){

        $name = $request->name;
        $money=$request->money;
        $sale=$request->sale;
        $level=$request->level;
        //return $level;
        DB::insert("insert into sale (id,name,money,sale,level) values (1,'$name',$money,$sale,$level)");
        return "OK";
        
    }
}
