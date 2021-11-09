<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEncuestadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuestado', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->integer('rangoedad_id')->unsigned();
            $table->foreign('rangoedad_id')->references('id')->on('rangoedad');
            $table->integer('genero_id')->unsigned();
            $table->foreign('genero_id')->references('id')->on('genero');
            $table->integer('encuesta_id')->unsigned();
            $table->foreign('encuesta_id')->references('id')->on('encuesta');
            $table->integer('antiguedad_id')->unsigned();
            $table->foreign('antiguedad_id')->references('id')->on('antiguedad');
            $table->integer('sector_id')->unsigned();
            $table->foreign('sector_id')->references('id')->on('sector');
            $table->integer('puesto_id')->unsigned();
            $table->foreign('puesto_id')->references('id')->on('puesto');
            $table->integer('estudio_id')->unsigned();
            $table->foreign('estudio_id')->references('id')->on('estudio');
            $table->integer('sede_id')->unsigned();
            $table->foreign('sede_id')->references('id')->on('sede');
            $table->integer('contrato_id')->unsigned();
            $table->foreign('contrato_id')->references('id')->on('contrato');
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
        Schema::table('encuestado', function (Blueprint $table) {
            //
        });
    }
}
