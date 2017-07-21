<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('estadia_id')->nullable()->unsigned();
            $table->foreign('estadia_id')->references('id')->on('estadias');
            $table->integer('entidadrole_id')->unsigned();
            $table->foreign('entidadrole_id')->references('id')->on('entidade_role');
            $table->integer('foliopadre_id')->nullable()->unsigned();
            $table->foreign('foliopadre_id')->references('id')->on('folios');
            $table->longText('comentario')->nullable();
            $table->boolean('credito')->default(0);
            $table->boolean('exoneracion')->default(0);
            $table->boolean('documento')->default(0);
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
        Schema::dropIfExists('folios');
    }
}
