<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Afiliado extends Model
{
    use SoftDeletes;

    protected $table = 'afiliados';
    protected $fillable = ['nombre', 'apellido', 'limite_credito', 'dni', 'email', 'id_usuario'];

    public function ventas()
    {
        return $this->hasMany('App\Venta', 'id_afiliado', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_usuario', 'id');
    }

    public function cuotasSociales()
    {
        return $this->hasMany('App\CuotaSocial', 'id_afiliado', 'id');
    }

    public function comprar($productos, $nroCuotas, $farmacia)
    {
        if($this->restricciones($productos, $farmacia))
            return 0;
        else
        {
            $monto = $productos->sum->precio;
            $solicitud = Solicitud::create(['fecha' => Carbon::now()->toDateTimeString(), 'monto' => $monto, 'nro_cuotas' => $nroCuotas, 'id_afiliado' => $this->id, 'id_farmacia' => $farmacia->id, 'estado' => EstadoSolicitud::PENDIENTE]);
            $solicitud->productos()->attach($productos->map(function($prod){return $prod->id;})->values());
        }
    }

    public function restricciones($productos, $farmacia)
    {
        $cantidadProductos = $productos->count() > 2;
        $superaLimiteCredito = $this->totalAdeudadoSinInteres() + $productos->sum(function($prod){return $prod->precio;}) > $this->limite_credito;
        $creditoLimiteRed = $farmacia->creditoRed() < $productos->sum(function($prod){ return $prod->precio;});
        return $cantidadProductos || $superaLimiteCredito || $creditoLimiteRed;
    }

    public function totalAdeudadoSinInteres()
    {
        return $this->ventas->sum(function(Venta $venta){ return $venta->totalAdeudadoSinInteres();});
    }

    public function totalAdeudado()
    {
        return $this->ventas->sum(function(Venta $venta){return $venta->totalAdeudado();});
    }

    public function pagar(&$monto)
    {
        $this->cuotasSociales->each(function($cuota) use (&$monto){
            $monto = $cuota->pagar($monto);
        });
        $cuotas = collect();
        $this->ventas->each(function ($venta) use ($cuotas){
            $cuotas->push($venta->cuotas);
        });

        $cuotas = $cuotas->flatten()->sortBy->id->sortByDesc->mora();

        $cuotas->each(function(Cuota $cuota) use (&$monto){
            $monto = $cuota->pagar($monto);
            if($monto == 0)
                return false;
        });

    }

    public function actualizarPunitoriosLocal()
    {
        $ventas = $this->ventas->map->actualizarPunitoriosLocal();
        $this->ventas = $ventas;
        return $this;
    }

}
