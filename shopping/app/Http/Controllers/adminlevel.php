<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminlevel extends Controller
{
    //
    public function levelset()
    {
        $level = DB::table('level')->get();
       
        return view('levelset', compact('level'));
    }
    public function levelfinish(Request $request)
    {

        $array = $request->array;
        unset($array[0]);
        $check = $request->check;
        for ($i = 1; $i <= count($array); $i++) {

            if ($array[$i] < 0) {
                return 'no';
            }elseif($array[$i]==null)
            {
                return "error";
            }
            DB::update("update level set money=$array[$i] where level=$i");
        }
        if($check=='true')
        {
            DB::update("update level set jump=1");
        }
        else
        {
            DB::update("update level set jump=0");
        }
        $level = DB::table('level')->get();
        $view= view('levelset', compact('level'))->renderSections()['all'];;
        return response()->json(['html' => $view]);
        // return $array;
    }
}
