<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->integer('price');
            $table->string('picture');
        });
        DB::table('products')->insert([
            ['name'=>'apple1','price'=>40,'picture'=>'1.jpg'],
            ['name'=>'apple2','price'=>30,'picture'=>'2.jpg'],
            ['name'=>'apple3','price'=>20,'picture'=>'3.jpg'],
            ['name'=>'apple4','price'=>10,'picture'=>'4.jpg'],
            ['name'=>'apple5','price'=>50,'picture'=>'5.jpg'],
            ['name'=>'apple6','price'=>660,'picture'=>'6.jpg'],
            ['name'=>'apple7','price'=>70,'picture'=>'7.jpg'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
