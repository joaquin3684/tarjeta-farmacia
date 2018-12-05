<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/11/18
 * Time: 21:12
 */

namespace App\services;


use App\Afiliado;
use App\ConfigMutual;
use App\Cuota;
use Carbon\Carbon;

class CobroService
{
    public function cobro($elem)
    {
        $elem = collect($elem);
        $afiliados = $elem->map(function($e){ return $e['id'];});
        $afiliados = Afiliado::with(['ventas' => function($q){
            $q->whereHas('cuotas', function($q){
                $q->whereColumn('pagado', '<', 'total');
            });
            $q->with(['cuotas' => function($q){
                $q->whereColumn('pagado', '<', 'total')
                ->with('movimientos');
            }]);
        }, 'cuotasSociales'])
            ->whereIn('id', $afiliados)->get();

        $afiliados->each(function(Afiliado $afiliado) use ($elem){
            $socio = $elem->first(function($soc) use ($afiliado){ return $soc['id'] == $afiliado->id;});
            $afiliado->pagar($socio['monto']);
        });
    }

    public function listadoDeCobros()
    {
        $afiliados = Afiliado::with(['ventas' => function($q){
            $q->whereHas('cuotas', function($q){
                $q->whereColumn('pagado', '<', 'total');
            });
            $q->with(['cuotas' => function($q){
                $q->whereColumn('pagado', '<', 'total')
                    ->with('movimientos');
            }]);
        }, 'cuotasSociales' => function($q){
            $q->where('pagado', '<', 'total');
        }])->whereHas('ventas.cuotas', function($q){
            $q->whereColumn('pagado', '<', 'total');
        })
            ->get();

        $afis = $afiliados->map->actualizarPunitoriosLocal();

        return $afis;
    }
}