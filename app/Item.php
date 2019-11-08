<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $table = "item";
    protected $fillable = ['contenido','valoracion_negativa', 'tipo_id','encuesta_id', 'opciones_codigo'];


    public function encuesta()
    {
    	return $this->belongsTo('App\Encuesta', 'encuesta_id', 'id');
    }

    public function tipo()
    {
        return $this->belongsTo('App\Tipo', 'tipo_id', 'id');
    }

}
