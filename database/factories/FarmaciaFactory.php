<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 30/11/18
 * Time: 11:23
 */
$factory->define(App\Farmacia::class, function (Faker\Generator $faker) {

    return [
        'nombre' => $faker->name,
        'domicilio' => $faker->address,
        'email' => $faker->email,
        'id_usuario' => 1
    ];
});