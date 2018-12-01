<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 30/11/18
 * Time: 11:23
 */
$factory->define(App\Afiliado::class, function (Faker\Generator $faker) {

    return [
        'nombre' => $faker->firstName,
        'apellido' => $faker->lastName,
        'limite_credito' => 1000,
        'dni' => $faker->randomNumber(8),
        'email' => $faker->email,
        'id_usuario' => 1
    ];
});