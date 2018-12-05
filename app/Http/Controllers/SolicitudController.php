<?php

namespace App\Http\Controllers;

use App\services\SolicitudService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudController extends Controller
{
    private $service;
    public function __construct(SolicitudService $service)
    {
        $this->service = $service;
    }

    public function aceptar(Request $request)
    {
         Db::transaction(function() use ($request){
            $this->service->aceptar($request->all());
        });
    }

    public function rechazar(Request $request, $id)
    {
        Db::transaction(function() use ($request, $id){
            $this->service->rechazar($request->all(), $id);
        });
    }

    public function all()
    {
        return $this->service->all();
    }
}
