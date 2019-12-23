<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlCustomizationClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_customization_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idClient');
            $table->integer('personalizeSections');
            $table->integer('personalizeAreasEquipments');
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
        Schema::dropIfExists('control_customization_clients');
    }
}
