<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudio extends Model
{
    protected $table = "estudio";
    protected $fillable = ['nivel'];

    public function encuestado()
    {
        return $this->hasMany('App\Encuestado');
    }
}
