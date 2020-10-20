<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        $upcheck = $request->upcheck;
        if ($upcheck == 'y') {
            $upcheck = '上架';
        } else {
            $upcheck = '未上架';
        }
        //return $upcheck;
        $check = DB::table('products')->select('name')->where('name', '=', "$chkname")->get();
        if (count($check) > 0) {
            return "rename";
        } elseif (($chkname == null) or ($chkprice == null) or ($chkquantity == null)) {
            return 'space';
        } else {
            DB::insert("insert into products (name,price,stock,category,status) values ('$chkname',$chkprice,$chkquantity,'$chktype','$upcheck')");
            $name = $chkname . '.jpg';
            $file->move(public_path() . '/image/', $name);
        }
    }
    public function productotal()
    {
        $products = DB::table('products')->get();
        $productype = DB::table('productype')->get();
        return view('productotal', compact('productype', 'products'));

    }
    public function changestatus(Request $request)
    {
        $status = $request->productstatus;
        $name = $request->productname;
        $tmpcate = Session::get('tmpcate');
        if($tmpcate=="")
        {
            $tmpcate='all';
        }
        DB::update("update products set status ='$status' where name = '$name'");
        //return 'xx';
        if($tmpcate=='all')
        {
            $products = DB::table('products')->get();
            $productype = DB::table('productype')->get();
        }
       else
       {
        $products = DB::table('products')->where('category','=',"$tmpcate")->get();
        $productype=DB::table('productype')->where('type','=',"$tmpcate")->get();

       }

        //return view('productotal',compact('products','productype'));
        $view = view('productotal', compact('products', 'productype'))->renderSections()['status'];

        return response()->json(['html' => $view]);

        //return $request;

    }
    public function formshow(Request $request)
    {       
      ;
        $type = $request->productcate;
        $products = DB::table('products')->get();
        $productype = DB::select("select type from productype where type='$type' UNION ALL select * from productype where type <>'$type' and type not like '%all%'");
        //return $productype;
       // return $request;
       
        $view = view('productotal', compact( 'products','productype'))->renderSections()['value'];
        return response()->json(['html' => $view]);
        
        return $productype;
        return $request;
    }
    public function editOK(Request $request)
    {
        $name =$request->name;
        $price =$request->price;
        $stock=$request->stock;
        $cate =$request->cate;
        $id =$request->id;
        
        $oldname =$request->oldname;

       // return $request;
        $check = DB::table('products')->select('name')->where('name','=',"$name")->get();
       $checkname=DB::select("select name from products where id<>$id and name ='$name'");
      // return $request;
    
       if(count($checkname)>0)
       {
           return "rename";
       }
       //return $cate;
        if($cate===0)
        {
        
            if($oldname==$name)
            {
              //  return "1";
                  DB::update("update products set  price=$price,stock=$stock where id =$id");
            }
            else
            {
               // return '2';
                DB::update("update products set  name='$name',price=$price,stock=$stock where id=$id");
            }
        }
        else
        {
            if($oldname==$name)
            {
                //return "X";
                  DB::update("update products set  price=$price,stock=$stock,category='$cate' where id =$id");
            }
            else
            {
                DB::update("update products set  name='$name',price=$price,stock=$stock,category='$cate',where id=$id'");

            }
        }
        $products=DB::table('products')->get();
        $productype=DB::table('productype')->get();
       // return $oldname.$name.$cate;
        $view = view('productotal', compact( 'products','productype'))->renderSections()['status'];
        return response()->json(['html' => $view]);
        //return $name."and".$price."and".$stock."and".$cate;
    }
    public function catechoose(Request $request)
    {
        $cate = $request->cate;
        
        if($cate=='all')
        {
            Session::put('tmpcate','all');
            $products = DB::table('products')->get();
            $productype=DB::table('productype')->get();
        }
        elseif($cate==null)
        {
            $products = DB::table('products')->get();
            $productype=DB::table('productype')->get();
        }
        else
        {
            Session::put('tmpcate',$cate);
            $products = DB::table('products')->where('category','=',"$cate")->get();
            $productype=DB::table('productype')->where('type','=',"$cate")->get();
        }
        $view=view('productotal',compact('products','productype'))->renderSections()['status'];
        return response()->json(['html'=>$view]);
    }
}
