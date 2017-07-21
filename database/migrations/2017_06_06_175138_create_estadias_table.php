<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estadias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reservacione_id')->nullable()->unsigned();
            $table->foreign('reservacione_id')->references('id')->on('reservaciones');
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
        Schema::dropIfExists('estadias');
    }
}
