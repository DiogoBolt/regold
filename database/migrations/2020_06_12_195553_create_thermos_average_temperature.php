<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThermosAverageTemperature extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thermos_average_temperature', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('client_thermo');
            $table->string('thermo_type');
            $table->string('imei')->nullable();
            $table->string('morning_temp')->nullable();
            $table->string('afternoon_temp')->nullable();
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
        Schema::dropIfExists('thermos_average_temperature');
    }
}
