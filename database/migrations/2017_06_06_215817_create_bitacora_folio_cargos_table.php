<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitacoraFolioCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora_folio_cargos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('folio_cargo_id')->nullable()->unsigned();
            $table->foreign('folio_cargo_id')->references('id')->on('folio_cargos');
            $table->integer('folio_id')->nullable()->unsigned();
            $table->foreign('folio_id')->references('id')->on('folios');
            $table->integer('foliodestino_id')->nullable()->unsigned();
            $table->foreign('foliodestino_id')->references('id')->on('folios');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('bitacora_tipo_cambio_id')->unsigned();
            $table->foreign('bitacora_tipo_cambio_id')->references('id')->on('bitacora_tipo_cambios');
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
        Schema::dropIfExists('bitacora_folio_cargos');
    }
}
