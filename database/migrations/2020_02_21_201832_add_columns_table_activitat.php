<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsTableActivitat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activitats', function (Blueprint $table) {
            $table->string('created_by');
            $table->integer('soci_tickets');
            $table->integer('nosoci_tickets');
            $table->string('status')->default('aprovat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activitats', function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->dropColumn('soci_tickets');
            $table->dropColumn('nosoci_tickets');
            $table->dropColumn('status');
        });
    }
}
