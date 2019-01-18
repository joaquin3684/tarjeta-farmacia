<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 18/01/19
 * Time: 16:26
 */
$factory->define(App\ObraSocial::class, function (Faker\Generator $faker) {

    return [
        'nombre' => $faker->company,
        'interes' => 10,
    ];
});