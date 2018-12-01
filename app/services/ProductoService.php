<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/11/18
 * Time: 12:42
 */

namespace App\services;


use App\Producto;

class ProductoService
{
    public function crear($elem)
    {
        $producto = Producto::create($elem);
        return $producto->id;
    }

    public function update($elem, $id)
    {
        $producto = Producto::find($id);
        $producto->fill($elem);
        $producto->save();
    }

    public function find($id)
    {
        return Producto::find($id);
    }

    public function all()
    {
        return Producto::all();
    }

    public function delete($id)
    {
        Producto::destroy($id);
    }
}