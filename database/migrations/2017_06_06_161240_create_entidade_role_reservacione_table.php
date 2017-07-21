<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntidadeRoleReservacioneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidade_role_reservacione', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reservacione_id')->unsigned();
            $table->foreign('reservacione_id')->references('id')->on('reservaciones');
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
        Schema::dropIfExists('entidade_role_reservacione');
    }
}
