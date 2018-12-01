<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/11/18
 * Time: 12:42
 */

namespace App\services;


use App\Farmacia;
use App\Perfiles;

class FarmaciaService
{

    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function crear($elem)
    {
        $id_usuario = $this->userService->crear(['name' => $elem['nombre'], 'password' => $elem['nombre'], 'id_perfil' => Perfiles::FARMACIA, 'email' => $elem['email']]);
        $elem['id_usuario'] = $id_usuario;
        $farmacia = Farmacia::create($elem);
        $farmacia->redes()->attach($elem['redes']);
        return $farmacia->id;
    }

    public function update($elem, $id)
    {
        $farmacia = Farmacia::find($id);
        $this->userService->update(['name' => $elem['nombre'], 'password' => $elem['nombre'], 'id_perfil' => Perfiles::FARMACIA, 'email' => $elem['email']], $farmacia->id_usuario);
        $farmacia->fill($elem);
        $farmacia->save();
        $farmacia->redes()->sync($elem['redes']);
    }

    public function find($id)
    {
        return Farmacia::with('redes')->find($id);
    }

    public function all()
    {
        return Farmacia::with('redes')->get();
    }

    public function delete($id)
    {
        Farmacia::destroy($id);

    }
}