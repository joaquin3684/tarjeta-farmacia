<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 18/01/19
 * Time: 16:19
 */

namespace App\services;


use App\ObraSocial;

class ObraSocialService
{
    private $afiliadoService;

    public function __construct()
    {
        $this->afiliadoService = new AfiliadoService();
    }

    public function crear($elem)
    {
        $red = ObraSocial::create($elem);
        return $red->id;
    }

    public function update($elem, $id)
    {
        $red = ObraSocial::find($id);
        $red->fill($elem);
        $red->save();
    }

    public function find($id)
    {
        return ObraSocial::find($id);
    }

    public function all()
    {
        return ObraSocial::all();
    }

    public function delete($id)
    {
        ObraSocial::destroy($id);
        $this->afiliadoService->delete($id);
    }
}