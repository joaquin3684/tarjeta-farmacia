<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 30/11/18
 * Time: 11:23
 */
$factory->define(App\Red::class, function (Faker\Generator $faker) {

    return [
        'nombre' => $faker->firstName,
        'credito' => 10000
    ];
});