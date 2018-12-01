<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Farmacia extends Model
{
    use SoftDeletes;

    protected $table = 'farmacias';
    protected $fillable = ['nombre', 'domicilio', 'email', 'id_usuario'];

    public function redes()
    {
        return $this->belongsToMany('App\Red', 'red_farmacia', 'id_farmacia','id_red');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_usuario', 'id');
    }

    public function creditoRed()
    {
        return $this->redes->filter(function($red){return $red->credito > 0;})->map(function($red){return $red->credito;})->sortByDesc()->first();
    }
}
