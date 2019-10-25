<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocisBaixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socis_baixes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('soci_id');
            $table->date('unergister_date');
            $table->date('reactivation_date')->nullable();
            $table->string('unregister_motive');
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
        Schema::dropIfExists('socis_baixes');
    }
}
