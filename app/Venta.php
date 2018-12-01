<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $filiable = ['fecha', 'capital_total', 'interes_total', 'nro_cuotas', 'id_afiliado', 'id_farmacia'];

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

        $capital= round($this->capital/$this->nro_cuotas,2);
        $interes = round($this->interes_total/$this->nro_cuotas, 2);
        for($i=1; $i<=$this->nro_cuotas; $i++)
            Cuota::create(['id_venta' =>  $this->id, 'capital' => $capital, 'interes' => $interes, 'fecha_vto' => Carbon::today()->addDays(30*$i), 'fecha_inicio' => Carbon::today()->addDays(30*($i-1)), 'nro_cuota' => $i]);

    }

    public function totalAdeudadoSinInteres()
    {
        return $this->cuotas->sum(function($cuota){
            return $cuota->totalAdeudadoSinIteres();
        });
    }

    public function totalAdeudado()
    {
        return $this->cuotas->sum(function($cuota){
            return $cuota->totalAdeudado();
        });
    }
}
