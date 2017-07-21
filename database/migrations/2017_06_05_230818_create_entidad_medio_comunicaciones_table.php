<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntidadMedioComunicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidad_medio_comunicaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('mediocomunicacione_id')->unsigned();
            $table->foreign('mediocomunicacione_id')->references('id')->on('medio_comunicaciones');
            $table->integer('entidade_id')->unsigned();
            $table->foreign('entidade_id')->references('id')->on('entidades');
            $table->string('valormediocomunicacion', 50);
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
        Schema::dropIfExists('entidad_medio_comunicaciones');
    }
}
