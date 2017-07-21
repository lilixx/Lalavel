<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadiaHabitacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estadia_habitaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('habitacione_id')->unsigned();
            $table->foreign('habitacione_id')->references('id')->on('habitaciones');
            $table->integer('estadia_id')->unsigned();
            $table->foreign('estadia_id')->references('id')->on('estadias');
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
        Schema::dropIfExists('estadia_habitaciones');
    }
}
