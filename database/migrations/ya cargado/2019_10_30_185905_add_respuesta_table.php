<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRespuestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuesta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_contenido');
            $table->string('respuesta');
            $table->integer('encuestado_id')->unsigned();
            $table->foreign('encuestado_id')->references('id')->on('encuestado');
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('item');
            $table->integer('opcion_id')->unsigned();
            $table->foreign('opcion_id')->references('id')->on('opcion');
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
        Schema::table('respuesta', function (Blueprint $table) {
            //
        });
    }
}
