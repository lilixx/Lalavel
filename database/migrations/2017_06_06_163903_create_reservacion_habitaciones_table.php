<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservacionHabitacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservacion_habitaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reservacione_id')->unsigned();
            $table->foreign('reservacione_id')->references('id')->on('reservaciones');
            $table->integer('habitacione_id')->unsigned();
            $table->foreign('habitacione_id')->references('id')->on('habitaciones');
            $table->integer('tarifa_id')->unsigned();
            $table->foreign('tarifa_id')->references('id')->on('tarifas');
            $table->date('fechaentrada');
            $table->date('fechasalida');
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
        Schema::dropIfExists('reservacion_habitaciones');
    }
}
