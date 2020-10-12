<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminlogin extends Controller
{
    //
    public function check(Request $request)
    {
        //return $request;
       //$admin = $request->admin;
       //$password=$request->adminp;
        $admin = $request->adminaccount;
        $password = $request->adminpassword;
        //return $admin;
        $check = DB::table('admin')->select('admin', 'password')->where('admin', '=', "$admin")->where('password', '=', "$password")->get();
        
         if (count($check) > 0) {
             //return response()->json(['url'=>url('/management')]);
             return view('management');
          
         } else {
             //return 'x';
             $request ->session()->flash('alert','請輸入正確帳號密碼');
             return redirect()->back();
          //  return redirect()->back()->with('jsAlert','請輸入正確帳號密碼');
         }

    }
    public function editmanage(Request $request){
        return view('usermanage');

    }
}
