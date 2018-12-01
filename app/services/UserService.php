<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 30/11/18
 * Time: 10:42
 */

namespace App\services;


use App\User;

class UserService
{
    public function crear($elem)
    {
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
        return User::find($id);
    }

    public function all()
    {
        return User::all();
    }

    public function delete($id)
    {
        User::destroy($id);
    }
}