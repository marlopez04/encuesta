<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $table = "puesto";
    protected $fillable = ['descripcion'];

    public function encuestado()
    {
        return $this->hasMany('App\Encuestado');
    }

}
