<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indice extends Model
{
    protected $table = "indice";
    protected $fillable = ['descripcion','estado'];


    public function relacion()
    {
    	return $this->belongsTo('App\Relacion', 'relacion_id', 'id');
    }

}
