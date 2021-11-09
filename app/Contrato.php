<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table = "contrato";
    protected $fillable = ['descripcion'];

    public function encuestado()
    {
        return $this->hasMany('App\Encuestado');
    }
}
