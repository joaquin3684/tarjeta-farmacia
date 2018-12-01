<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha');
            $table->double('capital_total');
            $table->double('interes_total');
            $table->integer('nro_cuotas');
            $table->integer('id_afiliado')->unsigned();
            $table->foreign('id_afiliado')->references('id')->on('afiliados');
            $table->integer('id_farmacia')->unsigned();
            $table->foreign('id_farmacia')->references('id')->on('farmacias');
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

        Schema::dropIfExists('ventas');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
