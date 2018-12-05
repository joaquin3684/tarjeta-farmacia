<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 03/12/18
 * Time: 22:02
 */
$factory->define(App\Cuota::class, function (Faker\Generator $faker) {

    return [
        'id_venta' => 1,
        'capital' => 100,
        'interes' => 50,
        'fecha_vto' => \Carbon\Carbon::today()->toDateString(),
        'fecha_inicio' => \Carbon\Carbon::today()->toDateString(),
        'interes_punitorio' => 0,
        'nro_cuota' => 1,
        'pagado' => 100,
        'total' => 150
    ];

});