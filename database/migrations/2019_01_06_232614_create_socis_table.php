<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_number')->unique();            
            $table->string('name');
            $table->string('surname');
            $table->string('second_surname');
            $table->string('dni');
            $table->string('phone');
            $table->string('mobile')->nullable();
            $table->date('birth_date');
            $table->string('sex');
            $table->string('soci_img');
            $table->string('email');
            $table->date('register_date');
            $table->date('unregister_date')->nullable();            
            $table->boolean('soci_protector');
            $table->string('road');
            $table->string('address');
            $table->string('address_num');
            $table->string('address_floor')->default('');
            $table->string('address_door')->default('');
            $table->string('postal_code');
            $table->string('city');
            $table->string('iban');
            $table->string('account_holder');
            $table->string('dni_holder');
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
        Schema::dropIfExists('socis');
    }
}
