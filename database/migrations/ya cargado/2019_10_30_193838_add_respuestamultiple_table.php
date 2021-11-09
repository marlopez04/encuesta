<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRespuestamultipleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuestamultiple', function (Blueprint $table) {
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
        Schema::drop('respuestamultiple');
    }
}
