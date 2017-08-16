<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicrocontroladoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microcontroladores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->double('temperatura');
            $table->double('monoxido');
            $table->double('radiacion');
            $table->double('latitud');
            $table->double('longitud');
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
        Schema::dropIfExists('microcontroladores');
    }
}
