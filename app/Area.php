<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = "area";
    protected $fillable = ['descripcion'];

    public function encuestado()
    {
        return $this->hasMany('App\Encuestado');
    }
}
