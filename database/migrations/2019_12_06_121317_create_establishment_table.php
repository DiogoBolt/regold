<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstablishmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner');
            $table->string('name');
            $table->string('comercial_name');
            $table->string('address');
            $table->string('invoice_address');
            $table->string('city');
            $table->string('invoice_city');
            $table->string('nif');
            $table->string('activity');
            $table->string('telephone');
            $table->string('payment_method');
            $table->string('salesman');
            $table->string('receipt_email');
            $table->string('nib');
            $table->string('regoldID');
            $table->string('transport_note');
            $table->rememberToken();
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
        Schema::dropIfExists('establishment');
    }
}
