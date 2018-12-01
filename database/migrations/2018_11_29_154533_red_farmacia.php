<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RedFarmacia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('red_farmacia', function (Blueprint $table) {

            $table->integer('id_farmacia')->unsigned();
            $table->foreign('id_farmacia')->references('id')->on('farmacias');
            $table->integer('id_red')->unsigned();
            $table->foreign('id_red')->references('id')->on('redes');
            $table->timestamps();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::dropIfExists('red_farmacia');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');


    }
}
