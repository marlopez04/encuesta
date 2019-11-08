<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{

    protected $table = "encuesta";
    protected $fillable = ['descripcion','fecha_realiz','fecha_finaliza', 'estado', 'user_id', 'user_modi_id'];

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function encuestado()
    {
        return $this->hasMany('App\Encuestado');
    }


}
