<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 30/11/18
 * Time: 11:23
 */
$factory->define(App\Solicitud::class, function (Faker\Generator $faker) {

    return [
        'fecha' => \Carbon\Carbon::today()->toDateTimeString(),
        'monto' => 100,
        'nro_cuotas' => 10,
        'id_afiliado' => 1,
        'id_farmacia' => 1,
        'estado' => \App\EstadoSolicitud::PENDIENTE,
        'observacion' => null
    ];
});