<?php

namespace App\Http\Controllers;

use App\services\ObraSocialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObraSocialController extends Controller
{
    private $service;
    public function __construct(ObraSocialService $service)
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

}
