<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarifasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarifas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('habitaciontipo_id')->nullable()->unsigned();
            $table->foreign('habitaciontipo_id')->references('id')->on('habitacion_tipos');
            $table->integer('servicio_id')->nullable()->unsigned();
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->string('nombre', 60);
            $table->float('valor');
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
        Schema::dropIfExists('tarifas');
    }
}
