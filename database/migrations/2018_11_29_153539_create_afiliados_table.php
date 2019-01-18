<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfiliadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('afiliados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('domicilio');
            $table->string('localidad');
            $table->string('provincia');
            $table->string('codigo_postal');
            $table->string('cuil');
            $table->integer('nro');
            $table->integer('piso')->nullable();
            $table->string('dpto')->nullable();
            $table->string('apellido');
            $table->string('email');
            $table->double('limite_credito');
            $table->integer('dni');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('usuarios');
            $table->integer('id_obra_social')->unsigned();
            $table->foreign('id_obra_social')->references('id')->on('obras_sociales');
            $table->softDeletes();
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

        Schema::dropIfExists('afiliados');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
