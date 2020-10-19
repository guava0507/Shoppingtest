<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminedit extends Controller
{
    //
    public function edituser($username)
    {
        $userdata = DB::table('users')->select('id', 'name', 'identcard', 'phone', 'email', 'address')->where('name', '=', "$username")->get();
        return view('adminedit', compact('userdata'));

    }
    public function userchange(Request $request)
    {

        $newname = $request->namech;
        $newident = $request->identch;
        $newaddress = $request->addressch;
        $newemail = $request->emailch;
        $newphone = $request->phonech;
        $newpassword = $request->passwordch;
        $id = $request->id;
        $oldname=$request->oldname;
        //return $oldname;
        //return $request;
        $checkemail = DB::select("select email from users where id <>$id and email='$newemail'");
        $checkident = DB::select("select identcard from users where id<>$id and identcard = '$newident'");

        if (count($checkemail) > 0) {
            return "emailused";
        }
        if (count($checkident) > 0) {
            return "idendused";
        }
       
        if ($newpassword == null) {
          
            if ($oldname == $newname) {
                DB::update("update users set identcard='$newident',phone='$newphone',address='$newaddress' where id=$id");
                
            } else {
                DB::update("update users set name='$newname',identcard='$newident',phone='$newphone',address='$newaddress' where id=$id");
            }
        } else {
            if ($oldname == $newname) {
                DB::update("update users set password='$newpassword',identcard='$newident',phone='$newphone',address='$newaddress' where id=$id");
            } else {
                DB::update("update users set password='$newpassword',name='$newname',identcard='$newident',phone='$newphone',address='$newaddress' where id=$id");
            }
        }
        $userdata=DB::select("select * from users where id=$id");
        
        $view = view('adminedit', compact('userdata'))->renderSections()['form'];
        return response()->json(['html' => $view]);

    }
}
