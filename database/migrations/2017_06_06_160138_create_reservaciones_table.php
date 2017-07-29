<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('reservacionprocedencia_id')->unsigned();
            $table->foreign('reservacionprocedencia_id')->references('id')->on('reservacion_procedencias');
            $table->integer('entidadtarjeta_id')->unsigned();
            $table->foreign('entidadtarjeta_id')->references('id')->on('entidad_tarjetas');
            $table->boolean('confirmada')->default(1);;
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
        Schema::dropIfExists('reservaciones');
    }
}
