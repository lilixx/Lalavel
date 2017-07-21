<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntidadContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidad_contactos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entidade_id')->unsigned();
            $table->foreign('entidade_id')->references('id')->on('entidades');
            $table->string('nombres', 110);
            $table->string('email', 50);
            $table->string('telefono', 30);
            $table->string('cargo', 40);
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
        Schema::dropIfExists('entidad_contactos');
    }
}
