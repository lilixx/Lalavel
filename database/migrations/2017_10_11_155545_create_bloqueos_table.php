<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBloqueosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bloqueos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('razonbloqueo_id')->nullable()->unsigned();
            $table->foreign('razonbloqueo_id')->references('id')->on('razonbloqueos');
            $table->integer('habitacione_id')->nullable()->unsigned();
            $table->foreign('habitacione_id')->references('id')->on('habitaciones');
            $table->date('fechainicio');
            $table->date('fechafin');
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
        Schema::dropIfExists('bloqueos');
    }
}
