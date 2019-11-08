<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('indice_id')->unsigned();
            $table->foreign('indice_id')->references('id')->on('indice');
            $table->integer('dimension_id')->unsigned();
            $table->foreign('dimension_id')->references('id')->on('dimension');
            $table->integer('factor_id')->unsigned();
            $table->foreign('factor_id')->references('id')->on('factor');
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('item');
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
        Schema::drop('relacion');
    }
}
