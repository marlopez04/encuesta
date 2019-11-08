<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RangoEdad extends Model
{
    protected $table = "rangoedad";
    protected $fillable = ['descripcion'];


    public function encuestado()
    {
        return $this->hasMany('App\Encuestado');
    }
}
