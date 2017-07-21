<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFolioCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folio_cargos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('servicio_id')->unsigned();
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->integer('folio_id')->unsigned();
            $table->foreign('folio_id')->references('id')->on('folios');
            $table->integer('descuento_id')->nullable()->unsigned();
            $table->foreign('descuento_id')->references('id')->on('descuentos');
            $table->integer('cantidad');
            $table->longText('comentariocubeta')->nullable();
            $table->boolean('cubeta')->default(0);
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
        Schema::dropIfExists('folio_cargos');
    }
}
