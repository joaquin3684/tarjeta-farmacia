<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/11/18
 * Time: 12:42
 */

namespace App\services;


use App\Afiliado;
use App\Farmacia;
use App\Perfiles;
use App\Producto;
use App\Venta;

class AfiliadoService
{

    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function crear($elem)
    {
        $id_usuario = $this->userService->crear(['name' => $elem['dni'], 'password' => $elem['dni'], 'id_perfil' => Perfiles::AFILIADO, 'email' => $elem['email']]);
        $elem['id_usuario'] = $id_usuario;
        $afiliado = Afiliado::create($elem);

        return $afiliado->id;
    }

    public function update($elem, $id)
    {
        $afiliado = Afiliado::find($id);
        $this->userService->update(['name' => $elem['dni'], 'password' => $elem['dni'], 'id_perfil' => Perfiles::AFILIADO, 'email' => $elem['email']], $afiliado->id_usuario);
        $afiliado->fill($elem);
        $afiliado->save();
    }

    public function find($id)
    {
        $afiliado = Afiliado::with('ventas.cuotas.movimientos')->find($id);
        $monto = $afiliado->totalAdeudadoSinInteres();
        $afiliado->totalAdeudadoSinInteres = $monto;
        return $afiliado;
    }

    public function all()
    {
        return Afiliado::all();
    }

    public function delete($id)
    {
        Afiliado::destroy($id);
    }

    public function compra($elem)
    {
        $productos = Producto::whereIn('id', $elem['productos'])->get();
        $afiliado = Afiliado::with('ventas.cuotas.movimientos')->find($elem['idAfiliado']);
        $farmacia = Farmacia::find($elem['idFarmacia']);
        return $afiliado->comprar($productos, $elem['nroCuotas'], $farmacia);
    }

    public function cuentaCorriente($id)
    {
        $ventas = Venta::with('productos', 'cuotas.movimientos')->where('id_afiliado', $id)->get();
        $ventas->each(function($venta){
            $venta->totalAdeudado = $venta->totalAdeudado();
            $venta->cuotas->each(function($cuota){
                $cuota->totalAdeudado = $cuota->totalAdeudado();
            });
        });

        return $ventas;
    }

    public function cuentaCorrienteAfiliados()
    {
        $afiliados = Afiliado::with('ventas.productos', 'ventas.cuotas.movimientos')->get();

        $afiliados->each(function($afiliado){
            $afiliado->totalAdeudado = $afiliado->totalAdeudado();
            $afiliado->ventas->each(function($venta){
                $venta->totalAdeudado = $venta->totalAdeudado();
                $venta->cuotas->each(function($cuota){
                     $cuota->totalAdeudado = $cuota->totalAdeudado();
                });
            });
        });
        return $afiliados;
    }






}