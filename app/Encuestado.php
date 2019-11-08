<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encuestado extends Model
{
    protected $table = "encuestado";
    protected $fillable = ['descripcion', 'area_id','rangoedad_id','genero_id','encuesta_id','antiguedad_id','sector_id','puesto_id','estudio_id', 'sede_id','contrato_id'];

    public function area()
    {
        return $this->belongsTo('App\Area', 'area_id', 'id');
    }

    public function rangoedad()
    {
    	return $this->belongsTo('App\RangoEdad', 'rangoedad_id', 'id');
    }

    public function genero()
    {
    	return $this->belongsTo('App\Genero', 'genero_id', 'id');
    }

    public function encuesta()
    {
    	return $this->belongsTo('App\Encuesta', 'encuesta_id', 'id');
    }

    public function antiguedad()
    {
    	return $this->belongsTo('App\Antiguedad', 'antiguedad_id', 'id');
    }

    public function sector()
    {
    	return $this->belongsTo('App\Sector', 'sector_id', 'id');
    }

    public function puesto()
    {
    	return $this->belongsTo('App\Puesto', 'puesto_id', 'id');
    }

    public function estudio()
    {
    	return $this->belongsTo('App\Estudio', 'estudio_id', 'id');
    }

    public function sede()
    {
        return $this->belongsTo('App\Sede', 'sede_id', 'id');
    }


    public function contrato()
    {
        return $this->belongsTo('App\Contrato', 'contrato_id', 'id');
    }

    public function respuestas()
    {
        return $this->hasMany('App\Respuesta');
    }

    public function respuestasmultiples()
    {
        return $this->hasMany('App\RespuestaMultiple');
    }

}
