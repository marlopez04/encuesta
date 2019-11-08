<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCantidadrmultipleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cantidadrmultiple', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('opcion_id')->unsigned();
            $table->foreign('opcion_id')->references('id')->on('opcion');
            $table->integer('encuestado_id')->unsigned();
            $table->foreign('encuestado_id')->references('id')->on('encuestado');            
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
        Schema::drop('cantidadrmultiple');
    }
}
