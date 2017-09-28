<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHabitacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('habitacion_tipo_id')->unsigned();
            $table->foreign('habitacion_tipo_id')->references('id')->on('habitacion_tipos');
            $table->integer('habitacion_area_id')->unsigned();
            $table->foreign('habitacion_area_id')->references('id')->on('habitacion_areas');
            $table->integer('numero');
            $table->longText('comentario')->nullable();
            $table->boolean('limpia')->default(1);
            $table->boolean('disponible')->default(1);
            $table->boolean('activo')->default(1);
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
        Schema::dropIfExists('habitaciones');
    }
}
