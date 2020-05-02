<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConcursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concurs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->string('password');
            $table->dateTime('start_votations_date');
            $table->dateTime('end_votations_date');
            $table->integer('punts_mesa');
            $table->integer('mesa_percent');
            $table->integer('soci_percent');
            $table->boolean('active');
            $table->boolean('finished');
            $table->integer('id_winner');
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
        Schema::dropIfExists('concurs');
    }
}
