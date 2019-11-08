<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = "tipo";
    protected $fillable = ['descripcion'];

    public function indice()
    {
        return $this->hasMany('App\Indice');
    }

    public function item()
    {
        return $this->hasMany('App\Item');
    }

    public function opcion()
    {
        return $this->hasMany('App\Opcion');
    }

}
