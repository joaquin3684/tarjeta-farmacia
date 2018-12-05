<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $fillable = ['fecha', 'capital_total', 'interes_total', 'nro_cuotas', 'id_afiliado', 'id_farmacia'];

    public function productos()
    {
        return $this->belongsToMany('App\Producto', 'venta_producto', 'id_venta', 'id_producto');
    }

    public function cuotas()
    {
        return $this->hasMany('App\Cuota', 'id_venta', 'id');
    }

    public function generarCuotas()
    {

        $capital= round($this->capital_total/$this->nro_cuotas,2);
        $interes = round($this->interes_total/$this->nro_cuotas, 2);
        for($i=1; $i<=$this->nro_cuotas; $i++)
            Cuota::create(['id_venta' =>  $this->id, 'capital' => $capital, 'interes' => $interes, 'fecha_vto' => Carbon::today()->addDays(30*$i), 'fecha_inicio' => Carbon::today()->addDays(30*($i-1)), 'nro_cuota' => $i, 'total' => $capital + $interes, 'fecha_calculo' => Carbon::today()->addDays(30*$i)]);

    }

    public function totalAdeudadoSinInteres()
    {
        return $this->cuotas->sum(function(Cuota $cuota){
            return $cuota->totalAdeudadoSinInteres();
        });
    }

    public function totalAdeudado()
    {
        return $this->cuotas->sum(function(Cuota $cuota){
            return $cuota->totalAdeudado();
        });
    }

    public function mora()
    {
        $this->cuotas->sum->mora();
    }

    public function pagar(&$monto)
    {
        $this->cuotas->each(function($cuota) use (&$monto){
            $monto = $cuota->pagar($monto);
        });
    }

    public function actualizarPunitoriosLocal()
    {
        $cuotas = $this->cuotas->map->actualizarPunitoriosLocal();
        $this->cuotas = $cuotas;
        return $this;
    }

}
