<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntidadTarjetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidad_tarjetas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entidadrole_id')->unsigned();
            $table->foreign('entidadrole_id')->references('id')->on('entidade_role');
            $table->bigInteger('numero');
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
        Schema::dropIfExists('entidad_tarjetas');
    }
}
