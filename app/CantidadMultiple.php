<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CantidadMultiple extends Model
{
    protected $table = "cantidadmultiple";
    protected $fillable = ['opcion_id','encuestado_id'];

    public function encuestado()
    {
    	return $this->belongsTo('App\Encuestado', 'encuestado_id', 'id');
    }

}
