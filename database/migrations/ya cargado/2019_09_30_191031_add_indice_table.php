<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->enum('estado', ['ACTIVA', 'FINALIZADA']);
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
        Schema::table('indice', function (Blueprint $table) {
            //
        });
    }
}
