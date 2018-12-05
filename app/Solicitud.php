<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';
    protected $fillable = ['fecha', 'monto', 'nro_cuotas', 'id_afiliado', 'id_farmacia', 'estado', 'observacion'];

    public function productos()
    {
        return $this->belongsToMany('App\Producto', 'solicitud_producto', 'id_solicitud', 'id_producto');
    }

    public function farmacia()
    {
        return $this->belongsTo('App\Farmacia', 'id_farmacia', 'id');
    }

    public function aceptar()
    {
        $interes = ConfigMutual::INTERES * $this->monto / 100;
        $capital = $this->monto;
        $venta = Venta::create(['fecha' => Carbon::now()->toDateTimeString(), 'capital_total' => $capital, 'interes_total' => $interes, 'nro_cuotas' => $this->nro_cuotas, 'id_afiliado' => $this->id_afiliado, 'id_farmacia' => $this->id_farmacia]);
        $venta->productos()->attach($this->productos->map(function($prod){return $prod->id;})->values());
        $venta->generarCuotas();

        $this->farmacia->reducirMontoRed($capital);

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
