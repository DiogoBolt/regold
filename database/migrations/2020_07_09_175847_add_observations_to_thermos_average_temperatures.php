<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddObservationsToThermosAverageTemperatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('thermos_average_temperature', function(Blueprint $table) {
            $table->text('observations')->nullable()->after('afternoon_temp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thermos_average_temperature', function(Blueprint $table) {
            $table->dropColumn('observations');
        });
    }
}
