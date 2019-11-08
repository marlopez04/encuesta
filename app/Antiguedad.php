<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antiguedad extends Model
{
    protected $table = "antiguedad";
    protected $fillable = ['rango'];

    public function encuestado()
    {
        return $this->hasMany('App\Encuestado');
    }
}

