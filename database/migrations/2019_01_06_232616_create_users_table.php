<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('soci_id')->nullable()->unsigned();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email');
            $table->string('password');
            $table->boolean('active')->default(1);
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('soci_id')
            ->references('id')->on('socis')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
