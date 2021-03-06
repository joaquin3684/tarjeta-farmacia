<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObraSocial extends Model
{
    use SoftDeletes;

    protected $table = 'obras_sociales';
    protected $fillable = ['nombre', 'interes'];

}
