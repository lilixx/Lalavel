<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntidadeEstadiaHabitacioneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidade_estadia_habitacione', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entidade_id')->unsigned();
            $table->foreign('entidade_id')->references('id')->on('entidades');
            $table->integer('estadia_habitacione_id')->unsigned();
            $table->foreign('estadia_habitacione_id')->references('id')->on('estadia_habitaciones');
            $table->date('fechaentrada')->nullable();
            $table->date('fechasalida')->nullable();
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
        Schema::dropIfExists('entidade_estadia_habitacione');
    }
}
