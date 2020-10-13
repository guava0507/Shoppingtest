<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class adminedit extends Controller
{
    //
    public function edituser($username)
    {
        $userdata = DB::table('users')->select('name', 'identcard', 'phone', 'email', 'address')->where('name', '=', "$username")->get();
        return view('adminedit', compact('userdata'));

    }
    public function userchange(Request $request)
    {
        $oldname = $request->oldename;
        $newname = $request->namech;
        $newident = $request->identch;
        $newaddress = $request->addressch;
        $newemail = $request->emailch;
        $newphone=$request->phonech;
        $newpassword = $request->passwordch;

        $checkname = DB::table('users')->select('name')->where('name', '=', "$newname")->get();
        $checkident = DB::table('users')->select('identcard')->where('identcard', '=', "$newident")->get();
        $checkemail = DB::table('users')->select('email')->where('email', '=', "$newemail")->get();
        if (count($checkname) > 1) {
            return "nameused";
        }
        if (count($checkident) > 1) {
            return 'identused';
        }
        if(count($checkemail)>1)
        {
            return 'emailused';
        }

        if ($newpassword == "") {
          //return $newemail;
            DB::update("update `users` set name='$newname',identcard='$newident',address='$newaddress',email='$newemail',phone='$newphone' where name='$newname'");
            
        } else {
            $hashpassword = Hash::make($newpassword);
            DB::update("update `users` set name='$newname',password='$hashpassword',identcard='$newident',address='$newaddress',email='$newemail' where name='$newname'");
            return "OK";
        }
        return "?";
    }
}
