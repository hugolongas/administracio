<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('concurs_id')->nullable()->unsigned();
            $table->string('project_name');
            $table->string('project_url');
            $table->string('project_file');
            $table->integer('vots_mesa');
            $table->double('vots_mesa_total');
            $table->integer('vots_soci');
            $table->double('vots_soci_total');
            $table->double('vots_total');
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
        Schema::dropIfExists('projects');
    }
}
