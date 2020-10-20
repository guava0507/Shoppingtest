<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class ProductSort extends Controller
{
    //
    public function selProduct(Request $request)
    {
        $option = $request['prosort'];
        $category = $request['cate'];
       
        
        if ($category == 'all') {
            Session::put('tmpcate','all');
        }
      elseif(!isset($category))
      {
        
      }
      else
      {
        Session::put('tmpcate',$category);
      }
     
        if ($option != "") {
            Session::put('tmpopt',$option);
        }
        $tmpcate=Session::get('tmpcate');
        $tmpopt =Session::get('tmpopt');
//種類排序
        if ($tmpopt=='') {
            switch ($category) {
                case 'all':
                    $products = DB::table('products')->where('status','=','上架')->get();
                    break;

                case $category:
                    $products = DB::table('products')->where('category', '=', "$category")->where('status','=','上架')->get();
                    break;
                    
            }

        } else {

            switch ($tmpopt) {
                case 1:
                    if ($category == 'all') {
                        $products = DB::table('products')->where('status','=','上架')->orderBy('created_at', 'desc')->get();
                    } else {
                        $products = DB::table('products')->where('category', '=',"$tmpcate")->where('status','=','上架')->orderBy('created_at', 'desc')->get();
                    }

                    break;
                case 2:
                    if ($category == 'all') {
                        $products = DB::table('products')->where('status','=','上架')->orderBy('price', 'desc')->get();
                    } else {
                        $products = DB::table('products')->where('category', '=',"$tmpcate")->where('status','=','上架')->orderBy('price', 'desc')->get();
                    }

                    break;
                case 3:
                    if ($category == 'all') {
                        $products = DB::table('products')->where('status','=','上架')->orderBy('name', 'asc')->get();
                    } else {
                        $products = DB::table('products')->where('category', '=', "$tmpcate")->where('status','=','上架')->orderBy('name', 'asc')->get();
                    }

                    break;
            }
        }

        //商品情況排序
        //return $_SESSION['tmpcate'];

        if ($tmpcate == 'all') {
            switch ($option) {
                case 1:
                    $products = DB::table('products')->where('status','=','上架')->orderBy('created_at', 'desc')->get();
                    break;
                case 2:
                    $products = DB::table('products')->where('status','=','上架')->orderBy('price', 'desc')->get();
                    break;
                case 3:
                    $products = DB::table('products')->where('status','=','上架')->orderBy('name', 'asc')->get();
                    break;
            }
        } else {
            switch ($option) {
                case 1:
                    $products = DB::table('products')->where('category', '=', "$tmpcate")->where('status','=','上架')->orderBy('created_at', 'desc')->get();
                    break;
                case 2:
                    $products = DB::table('products')->where('category', '=',"$tmpcate")->where('status','=','上架')->orderBy('price', 'desc')->get();
                    break;
                case 3:
                    $products = DB::table('products')->where('category', '=', "$tmpcate")->where('status','=','上架')->orderBy('name', 'asc')->get();
            }
        }
        //Session::put('tmpopt','');
       // return $tmpopt;
        $productype = DB::table('productype')->select('type')->get();
        $view = view('welcome', compact('products', 'productype'))->renderSections()['product'];
        return response()->json(['html' => $view]);

        // return view('welcome',compact('products'));
        //  return $category;
        //return $category;

    }
}
