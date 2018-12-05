<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 03/12/18
 * Time: 22:02
 */
$factory->define(App\Venta::class, function (Faker\Generator $faker) {

    return [
        'fecha' => \Carbon\Carbon::now()->toDateTimeString(),
        'capital_total' => 100,
        'interes_total' => 50,
        'nro_cuotas' => 3,
        'id_afiliado' => 1,
        'id_farmacia' => 1
    ];

});