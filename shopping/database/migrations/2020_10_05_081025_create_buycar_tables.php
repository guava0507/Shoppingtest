<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuycarTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('buycar', function (Blueprint $table) {
            //
            $table->string('proname');
            $table->integer('proprice');
            $table->integer('quantity');
            $table->integer('total');
            $table->string('name');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('buycar', function (Blueprint $table) {
            //
            $table->dropIfExists('buycar');
          
        });
    }
}
