<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProductDetail extends Controller
{
    //
    public function product($productd)
    {
        $detail=DB::table('products')->where('name','=',"$productd")->get();
        return view ('product',compact('detail'));
    }
}
