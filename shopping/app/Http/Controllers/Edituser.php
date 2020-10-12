<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class Edituser extends Controller
{
    //
    public function userdata(Request $request)
    {
        $user = Auth::user();
        $username = $user->name;
        $userdata=DB::table('users')->select('address','email')->where('name','=',"$username")->get();
        return  view('edituser',compact('userdata'));
    }
    public function chooseedit(Request $request)
    {
        $user = Auth::user();
        $username = $user->name;
        
       if(isset($request->newpass))
       {
           
           if((($request->newpass)or($request->agpass))==null)
            {
               
                return "re";
            }
            elseif($request->newpass!=$request->agpass)
            {
                return "re";
            }
            else
            {
               
                $password=$request->newpass;
                $password=Hash::make($password);
                DB::update("update users set password = '$password' where name = '$username'");
                return "OK";
            }
       }
       else{
     //  return $request;
        $newemail=$request->email;
        $newaddress=$request->address;
     // return $newemail;
         $checkemail=DB::select("select email from users where name ='$username' and email='$newemail'");
          if((($newaddress)or($newemail))==null)
          {
                return 're';
          }
          elseif(count($checkemail)>1)
          {
              return '重複';
          }
          else
          {
              //return "OK";
              DB::update("update users set email='$newemail',address='$newaddress' where name='$username'");
              return "OK";
          }
       }
    //     return  $request;
     }
    public function passcheck(Request $request)
    {
        $user = Auth::user();
        $username = $user->name;
        $usedata=DB::table('users')->select('password')->where('name','=',"$username")->get();
        $hashpassword=$usedata[0]->password;
        $password=$request->send;
       
        if(Hash::check("$password",$hashpassword))
        {
            return "Y";
        }
        else
        {
            return "X";
        }
    }
}
