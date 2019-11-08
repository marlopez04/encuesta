<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dimension extends Model
{

    protected $table = "dimension";
    protected $fillable = ['descripcion'];

    public function relacion()
    {
    	return $this->belongsTo('App\Relacion', 'relacion_id', 'id');
    }


}
