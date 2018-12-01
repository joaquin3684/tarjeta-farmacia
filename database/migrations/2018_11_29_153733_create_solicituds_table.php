<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('solicitudes', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha');
            $table->double('monto');
            $table->integer('nro_cuotas');
            $table->integer('id_farmacia')->unsigned();
            $table->foreign('id_farmacia')->references('id')->on('farmacias');
            $table->integer('id_afiliado')->unsigned();
            $table->foreign('id_afiliado')->references('id')->on('farmacias');
            $table->smallInteger('estado');
            $table->string('observacion');
            $table->timestamps();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
    protected $filiable = ['fecha', 'monto', 'nro_cuotas', 'id_afiliado', 'id_farmacia', 'estado', 'observacion'];

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::dropIfExists('solicitudes');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
