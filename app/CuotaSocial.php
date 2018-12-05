<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CuotaSocial extends Model
{
    protected $table = 'cuotas_sociales';
    protected $fillable = ['id_afiliado', 'fecha_vto', 'fecha_inicio', 'nro_cuota', 'pagado', 'total', 'fecha_pago'];

    public function pagar(&$monto)
    {
        if($monto != 0) {
            if($monto >= $this->total - $this->pagado)
            {
                $monto -= $this->total - $this->pagado;
                $this->pagado = $this->total;
            }
            else
            {
                $this->pagado += $monto;
                $monto = 0;
            }
            $this->fecha_pago = Carbon::today()->toDateString();
            $this->save();
            return $monto;
        }
    }
}
