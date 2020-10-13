<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminban extends Controller
{
    //
    public function ban(Request $request)
    {
        $banstatus = $request->banstatus;
        $username = $request->username;
        // return $banstatus;
        if ($banstatus == '封鎖') {
           DB::update("update `users` set  status='封鎖' where name = '$username'");
            
        } else {
            DB::update("update `users` set  status='啟用' where name = '$username'");
        
        }
       // return 'OK';
        $usershow=DB::table('users')->select('name','status')->get();
        //return $ban;
        $view = view('usermanage', compact('usershow'))->renderSections()['show'];
            return response()->json(['html' => $view]);

    }
}
