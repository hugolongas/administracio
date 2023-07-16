<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsTableSoci extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('socis', function (Blueprint $table) {
            $table->text('observacions')->nullable();
            $table->string('tipus_soci');
            $table->double('cuota_soci', 8, 2)->default(0);
            $table->dropColumn('soci_protector');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('socis', function (Blueprint $table) {
            $table->boolean('soci_protector');
            $table->dropColumn('observacions');
            $table->dropColumn('tipus_soci');
            $table->dropColumn('cuota_soci');
        });
    }
}
