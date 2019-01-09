<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'LoginController@login');
Route::get('prueba', function(){ return 1;});

Route::group(['middleware' => ['permisos', 'jwt.auth']], function() {

    // AFILIADO

    Route::post('afiliado/crear', 'AfiliadoController@store');
    Route::get('afiliado/all', 'AfiliadoController@all');
    Route::put('afiliado/editar/{id}', 'AfiliadoController@update');
    Route::get('afiliado/find/{id}', 'AfiliadoController@find');
    Route::post('afiliado/delete', 'AfiliadoController@delete');

    Route::post('afiliado/comprar', 'AfiliadoController@comprar');
    Route::get('afiliado/cuentaCorriente/{id}', 'AfiliadoController@cuentaCorriente');
    Route::get('afiliado/cuentaCorrienteAfiliados', 'AfiliadoController@cuentaCorrienteAfiliados');

    // FARMACIA

    Route::post('farmacia/crear', 'FarmaciaController@store');
    Route::get('farmacia/all', 'FarmaciaController@all');
    Route::put('farmacia/editar/{id}', 'FarmaciaController@update');
    Route::get('farmacia/find/{id}', 'FarmaciaController@find');
    Route::post('farmacia/delete', 'FarmaciaController@delete');

    // PRODUCTO

    Route::post('producto/crear', 'ProductoController@store');
    Route::get('producto/all', 'ProductoController@all');
    Route::put('producto/editar/{id}', 'ProductoController@update');
    Route::get('producto/find/{id}', 'ProductoController@find');
    Route::post('producto/delete', 'ProductoController@delete');

    // RED

    Route::post('red/crear', 'RedController@store');
    Route::get('red/all', 'RedController@all');
    Route::put('red/editar/{id}', 'RedController@update');
    Route::get('red/find/{id}', 'RedController@find');
    Route::post('red/delete', 'RedController@delete');

    // USUARIO

    Route::post('user/crear', 'UserController@store');
    Route::get('user/all', 'UserController@all');
    Route::put('user/editar/{id}', 'UserController@update');
    Route::get('user/find/{id}', 'UserController@find');
    Route::get('user/perfiles', 'UserController@perfiles');
    Route::post('user/delete', 'UserController@delete');
    Route::post('user/cambiarPassword', 'UserController@cambiarPassword');

    // SOLICITUD

    Route::get('solicitud/all', 'SolicitudController@all');
    Route::post('solicitud/rechazar', 'SolicitudController@rechazar');
    Route::post('solicitud/aceptar', 'SolicitudController@aceptar');

    // COBRO

    Route::post('cobro/cobrar', 'CobroController@cobrar');
    Route::get('cobro/listadoDeCobros', 'CobroController@listadoDeCobros');


});