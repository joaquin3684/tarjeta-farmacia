<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    protected $table = 'productos';
    protected $fillable = ['nombre', 'precio', 'id_red'];

    public function red()
    {
       return $this->belongsTo('App\Red', 'id_red', 'id');
    }
}
