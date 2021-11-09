<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    protected $table = "genero";
    protected $fillable = ['descripcion'];

    public function encuestado()
    {
        return $this->hasMany('App\Encuestado');
    }
}
