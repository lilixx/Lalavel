<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntidadDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidad_documentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entidade_id')->unsigned();
            $table->foreign('entidade_id')->references('id')->on('entidades');
            $table->smallInteger('tipodocumento_id')->unsigned();
            $table->foreign('tipodocumento_id')->references('id')->on('tipo_documentos');
            $table->string('valordocumento', 50);
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
        Schema::dropIfExists('entidad_documentos');
    }
}
