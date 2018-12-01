<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';
    protected $filiable = ['fecha', 'monto', 'nro_cuotas', 'id_afiliado', 'id_farmacia', 'estado', 'observacion'];

    public function productos()
    {
        return $this->belongsToMany('App\Solicitud', 'solicitud_producto', 'id_solicitud', 'id_producto');
    }

    public function aceptar()
    {
        $interes = ConfigMutual::INTERES * $this->monto;
        $capital = $this->monto;
        $venta = Venta::create(['fecha' => Carbon::today()->toDateTimeString(), 'capital_total' => $capital, 'interes_total' => $interes, 'nro_cuotas' => $this->nro_cuotas, 'id_afiliado' => $this->id_afiliado, 'id_farmacia' => $this->id_farmacia]);
        $venta->productos()->attach($this->productos->map(function($prod){return $prod->id;})->values());
        $venta->generarCuotas();

        $venta->farmacia->reducirMontoRed();

        $this->estado = EstadoSolicitud::CONFIRMADO;
        $this->save();

    }


    public function rechazar($observacion)
    {
        $this->observacion = $observacion;
        $this->estado = EstadoSolicitud::RECHAZADO;
        $this->save();
    }
}
