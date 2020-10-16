<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminproductmanage extends Controller
{
    //
    public function choose(Request $request)
    {

        return view('productmanage');
    }
    public function addproduct()
    {
        $productval = DB::table('productype')->where('type', 'not like', '%all%')->get();

        return view('addproduct', compact('productval'));
    }
    public function addfinish(Request $request)
    {
        
        $file = $request->file;
        
        $chkname = $request->productid;
        $chkprice = $request->productprice;
        $chkquantity = $request->productquantity;
        $chktype = $request->newproduct;
        $check = DB::table('products')->select('name')->where('name', '=', "$chkname")->get();
        if (count($check) > 0) {
            return "rename";
        } elseif (($chkname == null) or ($chkprice == null) or ($chkquantity == null)) {
            return 'space';
        } else {
            DB::insert("insert into products (name,price,stock,category) values ('$chkname',$chkprice,$chkquantity,'$chktype')");
            $name=$chkname.'.jpg';
            $file->move(public_path().'/image/',$name);
        }
    }
    public function productotal(){
        $products=DB::table('products')->get();
        $productype=DB::table('productype')->get();
        return view('productotal',compact('productype','products'));

    }
}
