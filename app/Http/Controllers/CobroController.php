<?php

namespace App\Http\Controllers;

use App\services\CobroService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CobroController extends Controller
{
    private $service;
    public function __construct(CobroService $service)
    {
        $this->service = $service;
    }


    public function cobrar(Request $request)
    {
        Db::transaction(function() use ($request){
            $this->service->cobro($request->all());
        });
    }

    public function listadoDeCobros()
    {
        return $this->service->listadoDeCobros();
    }

}
