<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 30/11/18
 * Time: 11:23
 */
$factory->define(App\Producto::class, function (Faker\Generator $faker) {

    return [
        'nombre' => $faker->name,
        'precio' => $faker->randomNumber()
    ];
});