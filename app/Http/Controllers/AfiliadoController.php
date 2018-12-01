<?php

namespace App\Http\Controllers;

use App\Red;
use App\services\AfiliadoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AfiliadoController extends Controller
{

    private $service;
    public function __construct(AfiliadoService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        return Db::transaction(function() use ($request){
            return $this->service->crear($request->all());
        });
    }

    public function update(Request $request, $id)
    {
        Db::transaction(function() use ($request, $id){
            $this->service->update($request->all(), $id);
        });
    }

    public function delete(Request $request)
    {
        $this->service->delete($request['id']);
    }

    public function find($id)
    {
        return $this->service->find($id);
    }

    public function all()
    {
        return $this->service->all();
    }

    public function comprar(Request $request)
    {
       return Db::transaction(function() use ($request){
            return $this->service->compra($request->all());
        });
    }

    public function cuentaCorriente($id)
    {
        return $this->service->cuentaCorriente($id);
    }

    public function cuentaCorrienteAfiliados()
    {
        return $this->service->cuentaCorrienteAfiliados();
    }


}
