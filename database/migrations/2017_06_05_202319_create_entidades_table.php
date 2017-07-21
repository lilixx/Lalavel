<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidades', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('paise_id')->nullable()->unsigned();
          $table->foreign('paise_id')->references('id')->on('paises');
          $table->smallInteger('tipoentidade_id')->unsigned();
          $table->foreign('tipoentidade_id')->references('id')->on('tipo_entidades');
          $table->string('nombres', 80);
          $table->string('apellidos', 80)->nullable();
          $table->longText('direccion')->nullable();
          $table->string('profesion', 40)->nullable();;
          $table->date('fecha_nac')->nullable();;
          $table->char('sexo', 4)->nullable();
          $table->string('estado_civil', 30)->nullable();
          $table->string('num_ruc', 50)->nullable();
          $table->longText('comentario')->nullable();
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
        Schema::dropIfExists('entidades');
    }
}
