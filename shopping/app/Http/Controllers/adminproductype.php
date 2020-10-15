<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminproductype extends Controller
{
    //
    public function type(Request $request)
    {
        $type = DB::table('productype')->select('type')->get();
        return view('typemanage', compact('type'));
    }
    public function change(Request $request)
    {

        $change = $request->typechange;
        $add = $request->addtext;
        $text = $request->x;
        if ((($text == 'false') and ($add == ""))) {
            return 'white';
        }
        if((($text == 'true') and ($add == ""))) {
            DB::table('productype')->truncate();
            for ($i = 0; $i < count($change); $i++) {
                DB::insert("insert into productype (type) values ('$change[$i]')");
            }
            $type = DB::table('productype')->select('type')->get();
            $view = view('typemanage', compact('type'))->renderSections()['change'];
            return response()->json(['html' => $view]);

        }

        $check = DB::table('productype')->select('type')->where('type', '=', "$add")->get();

        if (count($check) != 0) {
            return 'false';
        } else {
            DB::table('productype')->truncate();

            for ($i = 0; $i < count($change); $i++) {
                DB::insert("insert into productype (type) values ('$change[$i]')");
            }

            DB::insert("insert into productype (type) values ('$add')");
        }
        
        $type = DB::table('productype')->select('type')->get();
        $view = view('typemanage', compact('type'))->renderSections()['change'];
        return response()->json(['html' => $view]);

        //return count($change);
    }
}
