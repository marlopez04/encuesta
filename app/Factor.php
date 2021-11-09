<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    protected $table = "factors";
    protected $fillable = ['descripcion'];

    public function relacion()
    {
    	return $this->belongsTo('App\Relacion', 'relacion_id', 'id');
    }

}
