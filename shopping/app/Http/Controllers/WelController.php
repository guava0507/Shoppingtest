<?php

namespace App\Http\Controllers;

session_start();
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelController extends Controller
{

    //
    public function welcome()
    {
        $products = DB::table('products')->get();

        return view('welcome')->with('products', $products);

    }
    public function selProduct(Request $request)
    {
        $option = $request['prosort'];
        $category = $request['cate'];
        if (($category != "") or ($category == 'all')) {
            $_SESSION['tmpcate'] = $category;
        }
        if ($option != "") {
            $_SESSION['tmpopt'] = $option;
        }
//種類排序
        if(!isset($_SESSION['tmpopt']))
        {
        switch ($category) {
            case 'all':
                $products = DB::table('products')->get();
                break;

            case $category:
                $products = DB::table('products')->where('category', '=', "$category")->get();
                break;
        }
    }
    else
    {
        switch($_SESSION['tmpopt'])
        {
            case 1 :
            if($category=='all')
            $products = DB::table('products')->orderBy('created_at', 'desc')->get();
            else
            $products = DB::table('products')->where('category', '=', $_SESSION['tmpcate'])->orderBy('created_at', 'desc')->get();
             break;
             case 2 :
             if($category=='all')
                $products = DB::table('products')->orderBy('price', 'desc')->get();
            else
            $products = DB::table('products')->where('category', '=', $_SESSION['tmpcate'])->orderBy('price', 'desc')->get();
             break;
             case 3 :
             if($category=='all')
                $products = DB::table('products')->orderBy('name', 'asc')->get();
            else
            $products = DB::table('products')->where('category', '=', $_SESSION['tmpcate'])->orderBy('name', 'asc')->get();
             break;
        }
    }

    //商品情況排序
        if ($_SESSION['tmpcate'] == 'all') {
            switch ($option) {
                case 1:
                    $products = DB::table('products')->orderBy('created_at', 'desc')->get();
                    break;
                case 2:
                    $products = DB::table('products')->orderBy('price', 'desc')->get();
                    break;
                case 3:
                    $products = DB::table('products')->orderBy('name', 'asc')->get();
                    break;
            }
        } else {
            switch ($option) {
                case 1:
                    $products = DB::table('products')->where('category', '=', $_SESSION['tmpcate'])->orderBy('created_at', 'desc')->get();
                    break;
                case 2:
                    $products = DB::table('products')->where('category', '=', $_SESSION['tmpcate'])->orderBy('price', 'desc')->get();
                    break;
                case 3:
                    $products = DB::table('products')->where('category', '=', $_SESSION['tmpcate'])->orderBy('name', 'asc')->get();
            }
        }
        // switch ($option) {
        


        $view = view('welcome', compact('products'))->renderSections()['product'];
        return response()->json(['html' => $view]);
        // return view('welcome',compact('products'));
        //  return $category;

    }
}
