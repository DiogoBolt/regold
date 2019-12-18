<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentSectionCLientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_section_c_lient', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idClient');
            $table->integer('idArea');
            $table->integer('idProduto');
            $table->string('degignation');
            $table->integer('idCleaningFrequency');
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
        Schema::dropIfExists('equipment_section_c_lient');
    }
}
