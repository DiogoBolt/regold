<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('details');
            $table->string('ref');
            $table->string('price1');
            $table->string('price2');
            $table->string('price3');
            $table->string('amount2');
            $table->string('amount3');
            $table->string('category');
            $table->string('file');
            $table->string('manual');
            $table->string('seguranca');
            $table->timestamps();
        });

        Schema::create('order_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('cart_id');
            $table->string('amount');
            $table->string('total');
            $table->timestamps();
        });

        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->timestamps();
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
        Schema::dropIfExists('product');
        Schema::dropIfExists('order_line');
        Schema::dropIfExists('order');
    }
}
