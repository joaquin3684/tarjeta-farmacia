<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/11/18
 * Time: 12:43
 */

namespace App\services;


use App\Red;

class RedService
{
    public function crear($elem)
    {
        $red = Red::create($elem);
        return $red->id;
    }

    public function update($elem, $id)
    {
        $red = Red::find($id);
        $red->fill($elem);
        $red->save();
    }

    public function find($id)
    {
        return Red::find($id);
    }

    public function all()
    {
        return Red::all();
    }

    public function delete($id)
    {
        Red::destroy($id);
    }
}