<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    protected $table = 'cuotas';
    protected $fillable = ['id_venta', 'capital', 'interes', 'fecha_vto', 'fecha_inicio', 'interes_punitorio', 'nro_cuota'];

    public function movimientos()
    {
        return $this->hasMany('App\Movimiento', 'id_cuota', 'id');
    }


    public function totalAdeudadoSinInteres()
    {
        return $this->capital - $this->movimientos->sum(function($movimiento){ return $movimiento->ingreso;});
    }

    public function totalAdeudado()
    {
        return $this->capital + $this->interes + $this->interes_punitorio - $this->movimientos->sum(function($movimiento){ return $movimiento->ingreso;});
    }
}
