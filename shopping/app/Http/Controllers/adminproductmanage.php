<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class adminproductmanage extends Controller
{
    //
    public function choose(Request $request){

        return view('productmanage');
    }
    public function addproduct(){
        $productval=DB::table('productype')->where('type','not like','%all%')->get();

        return view('addproduct',compact('productval'));
    }
    public function addfinish(Request $request)
    {
        $chkname= $request->productid;
        
        $check=DB::table('products')->select('name')->where('name','=',"$chkname")->get();
      
       
        $filename=$chkname;
        if(isset($_FILES["file"]["name"]))
        {
            rename(($_FILES["file"]["name"]), $filename);
        }
       move_uploaded_file($_FILES["file"]["tmp_name"], "public/image/".$filename.".jpg");
        return count($check);
        return $request;
    }
}
