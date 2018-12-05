<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/11/18
 * Time: 14:36
 */

namespace App\services;


use App\Solicitud;

class SolicitudService
{
    public function aceptar($elem)
    {
        $solicitud = Solicitud::with('farmacia', 'productos')->find($elem['id']);
        $solicitud->aceptar();
    }

    public function rechazar($elem)
    {
        $solicitud = Solicitud::find($elem['id']);
        $solicitud->rechazar($elem['observacion']);
    }

    public function all()
    {
        return Solicitud::with('farmacia', 'productos')->get();
    }
}