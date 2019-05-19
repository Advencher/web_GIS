<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSampleViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('samples_view_new', function (Blueprint $table) {
            $table->integer('id_sample');
            $table->dateTimeTz('date');
            $table->char('comment', 128);
            $table->char('serial_number', 32);
            $table->integer('id_station');
            $table->char('station_name', 64);
            $table->integer('station_serial_number');
            $table->char('water_area_name', 128);
            $table->integer('id_station_coord');
            $table->double('longitude');
            $table->double('latitude');
            $table->char('longitude_str', 16);
            $table->char('latitude_str', 16);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('samples_view_new');
    }
}
