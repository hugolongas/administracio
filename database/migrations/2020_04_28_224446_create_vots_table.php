<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->nullable()->unsigned();
            $table->integer('concurs_id')->nullable()->unsigned();
            $table->integer('soci_id')->nullable()->unsigned();
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
        Schema::dropIfExists('vots');
    }
}
