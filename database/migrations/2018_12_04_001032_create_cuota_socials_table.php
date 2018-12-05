<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuotaSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('cuotas_sociales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_afiliado')->unsigned();
            $table->foreign('id_afiliado')->references('id')->on('afiliados');
            $table->double('pagado')->default(0);
            $table->double('total');
            $table->date('fecha_vto');
            $table->date('fecha_inicio');
            $table->date('fecha_pago')->nullable();
            $table->integer('nro_cuota');
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

        Schema::dropIfExists('cuotas_sociales');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
