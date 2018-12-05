<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/09/18
 * Time: 16:33
 */

use Illuminate\Support\Facades\Hash;

$factory->define(App\User::class, function (Faker\Generator $faker) {

    return [
        'name' => 'martin',
        'email' => 'martin@prueba',
        'password' => 'martin',
        'id_perfil' => 1


    ];
});