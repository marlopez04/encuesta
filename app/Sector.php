<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $table = "sector";
    protected $fillable = ['descripcion','activo', 'area'];

    public function encuestado()
    {
        return $this->hasMany('App\Encuestado');
    }
}
