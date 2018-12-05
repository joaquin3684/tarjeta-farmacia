<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    protected $table = 'cuotas';
    protected $fillable = ['id_venta', 'capital', 'interes', 'fecha_vto', 'fecha_inicio', 'interes_punitorio', 'nro_cuota', 'pagado', 'total', 'actualizacion_punitorios', 'fecha_calculo'];

    public function movimientos()
    {
        return $this->hasMany('App\Movimiento', 'id_cuota', 'id');
    }

    public function totalAdeudadoSinInteres()
    {
        return $this->capital - $this->pagado * $this->capital / $this->total;
    }

    public function totalAdeudado()
    {
        return $this->capital + $this->interes + $this->interes_punitorio - $this->pagado;
    }

    public function mora()
    {
        if($this->totalAdeudado() == 0)
            return 0;
        else {
            if (Carbon::today()->diffInDays(Carbon::createFromFormat('Y-m-d', $this->fecha_vto), false) < 0)
                return Carbon::today()->diffInDays(Carbon::createFromFormat('Y-m-d', $this->fecha_vto));
            else
                return 0;
        }
    }

    public function pagar(&$monto)
    {
        if($monto != 0) {
            $this->actualizarPunitorios();
            if($monto >= $this->total - $this->pagado)
            {
                Movimiento::create(['id_cuota' => $this->id, 'ingreso' => $this->total - $this->pagado, 'salida' => 0, 'fecha' => Carbon::today()->toDateString()]);

                $monto -= $this->total - $this->pagado;
                $this->pagado = $this->total;
            }
            else
            {
                $this->pagado += $monto;
                Movimiento::create(['id_cuota' => $this->id, 'ingreso' => $monto, 'salida' => 0, 'fecha' => Carbon::today()->toDateString()]);
                $monto = 0;
                if(Carbon::today()->greaterThan(Carbon::createFromFormat('Y-m-d', $this->fecha_vto))) {
                    $this->fecha_calculo = Carbon::today()->toDateString();
                }
            }
            $this->save();
            return $monto;
        }
    }

    public function actualizarPunitorios()
    {
        if($this->actualizacion_punitorios != Carbon::today()->toDateString())
        {
            $fechaCalculo = Carbon::createFromFormat('Y-m-d', $this->fecha_calculo);

            if(Carbon::today()->greaterThan($fechaCalculo))
            {
                $this->interes_punitorio += (($this->total - $this->pagado) * ConfigMutual::INTERES_PUNITORIO / 100) * $fechaCalculo->diffInDays(Carbon::today());
                $this->total = $this->capital + $this->interes + $this->interes_punitorio;
                $this->actualizacion_punitorios = Carbon::today()->toDateString();
                $this->save();
            }
        }
    }

    public function actualizarPunitoriosLocal()
    {
        if($this->actualizacion_punitorios != Carbon::today()->toDateString())
        {
            $fechaCalculo = Carbon::createFromFormat('Y-m-d', $this->fecha_calculo);

            if(Carbon::today()->greaterThan($fechaCalculo))
            {
                $this->interes_punitorio += (($this->total - $this->pagado) * ConfigMutual::INTERES_PUNITORIO / 100) * $fechaCalculo->diffInDays(Carbon::today());
                $this->total = $this->capital + $this->interes + $this->interes_punitorio;
                $this->actualizacion_punitorios = Carbon::today()->toDateString();
            }
        }
        return $this->getAttributes();
    }
}
