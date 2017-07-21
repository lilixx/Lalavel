<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntidadeRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidade_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entidade_id')->unsigned();
            $table->foreign('entidade_id')->references('id')->on('entidades');
            $table->smallInteger('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');
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
        Schema::dropIfExists('entidade_role');
    }
}
