<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha');
            $table->double('ingreso');
            $table->double('salida');
            $table->integer('id_cuota')->unsigned();
            $table->foreign('id_cuota')->references('id')->on('cuotas');
            $table->timestamps();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
    protected $fillable = ['fecha', 'ingreso', 'salida', 'id_cuota'];

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::dropIfExists('movimientos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
