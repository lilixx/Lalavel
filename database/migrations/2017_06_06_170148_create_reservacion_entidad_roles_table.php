<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservacionEntidadRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservacion_entidad_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reservacion_habitacione_id')->unsigned();
            $table->foreign('reservacion_habitacione_id')->references('id')->on('reservacion_habitaciones');
            $table->integer('entidade_role_id')->unsigned();
            $table->foreign('entidade_role_id')->references('id')->on('entidade_role');
            $table->boolean('encargado')->default(0);
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
        Schema::dropIfExists('reservacion_entidad_roles');
    }
}
