<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 03/12/18
 * Time: 22:02
 */
$factory->define(App\CuotaSocial::class, function (Faker\Generator $faker) {

    return [
        'id_afiliado' => 1,
        'fecha_vto' => \Carbon\Carbon::today()->toDateString(),
        'fecha_inicio' => \Carbon\Carbon::today()->toDateString(),
        'fecha_pago' => \Carbon\Carbon::today()->toDateString(),
        'nro_cuota' => 1,
        'pagado' => 100,
        'total' => 150
    ];

});