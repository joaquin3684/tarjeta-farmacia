<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 30/11/18
 * Time: 10:42
 */

namespace App\services;


use App\Perfil;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function crear($elem)
    {
        $elem['password'] =  Hash::make($elem['password']);
        $user = User::create($elem);
        return $user->id;
    }

    public function update($elem, $id)
    {
        $user = User::find($id);
        $user->fill($elem);
        $user->save();
    }

    public function find($id)
    {
        return User::with('perfil')->find($id);
    }

    public function all()
    {
        return User::with('perfil')->get();
    }

    public function delete($id)
    {
        User::destroy($id);
    }

    public function cambiarPassword($elem)
    {
        $user = User::find($elem['id']);
        $user->password = Hash::make($elem['password']);
        $user->save();

    }

    public function perfiles()
    {
        return Perfil::all();
    }
}