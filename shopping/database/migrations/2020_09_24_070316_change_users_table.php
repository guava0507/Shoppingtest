<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //up執行時對資料庫異動的地方
    public function up()
    {
        //
        Schema::table('users', function(Blueprint $table){
            //在欄位後新增欄位
            $table->string('identcard')->after('password');
            //$table->string('address')->after('identcard');
            $table->string('phone')->after('identcard');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    //down撤銷異動
    public function down()
    {
        //
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn('phone');
           // $table->drop('address');
            $table->dropColumn('identcard');
        });
    }
}
