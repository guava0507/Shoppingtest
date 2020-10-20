<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminsale extends Controller
{
    //
    public function sale()
    {
        return view('sale');
    }
    public function moneysale(Request $request)
    {

        $name = $request->name;
        $money = $request->money;
        $sale = $request->sale;
        $level = $request->level;
        //return $level;
        if (($name == null) or ($money == null) or ($sale == null) or ($level == null)) {
            return "space";
        }
        $checkname = DB::table('sale')->select('name')->where('name', '=', "$name")->where('type', '=', '1')->get();
        if (count($checkname) > 0) {
            return "rename";
        } else {
            DB::insert("insert into sale (type,name,money,sale,level) values (1,'$name',$money,$sale,$level)");
        }
        return "OK";

    }
    public function moneyfree(Request $request)
    {
        $name = $request->name;
        $money = $request->money;
        $sale = $request->sale;
        $level = $request->level;
        if (($name == null) or ($money == null) or ($sale == null) or ($level == null)) {
            return "space";
        }
        $checkname = DB::table('sale')->select('name')->where('name', '=', "$name")->where('type', '=', '2')->get();
        if (count($checkname) > 0) {
            return "rename";
        } else {
            DB::insert("insert into sale (type,name,money,sale,level) values (2,'$name',$money,$sale,$level)");
        }
        return 'OK';
    }
    public function salelist()
    {
        $sale = DB::table('sale')->select('*')->where('type', '=', '1')->get();
        $money = DB::table('sale')->select('*')->where('type', '=', '2')->get();

        return view('salelist', compact('sale', 'money'));

    }
    public function saleedit(Request $request)
    {
        $name = $request->name;
        $money = $request->money;
        $sale = $request->sale;
        $id = $request->id;
        $level = $request->level;

        $check = DB::select("select name from sale where saleId<>$id  and name='$name'");
        if (count($check) > 0) {
            return "rename";
        } else {
            DB::update("update sale set name='$name',money=$money,sale=$sale,level=$level where saleId=$id");

            $money = DB::table('sale')->select('*')->where('type', '=', '2')->get();
            $sale = DB::table('sale')->select('*')->where('type', '=', '1')->get();

            $view = view('salelist', compact('sale', 'money'))->renderSections()['table'];
            return response()->json(['html' => $view]);
            // return view('salelist',compact('sale','money'));
        }
        return $request;
    }
    public function saledel(Request $request)
    {
        $id = $request->id;
        DB::delete("delete from sale where saleId = $id");
       
        $money = DB::table('sale')->select('*')->where('type', '=', '2')->get();
        $sale = DB::table('sale')->select('*')->where('type', '=', '1')->get();

        $view = view('salelist', compact('sale', 'money'))->renderSections()['table'];
        return response()->json(['html' => $view]);
    }
}
