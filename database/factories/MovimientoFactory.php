<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 03/12/18
 * Time: 22:02
 */
$factory->define(App\Movimiento::class, function (Faker\Generator $faker) {

    return [
        'fecha' => \Carbon\Carbon::today()->toDateString(),
        'ingreso' => 0,
        'salida' => 0,
        'id_cuota' => 1
    ];
});