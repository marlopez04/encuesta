<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RespuestaMultiple extends Model
{

    protected $table = "respuestamultiple";
    protected $fillable = ['item_contenido','encuestado_id','item_id','opcion_id'];
    
    public function encuestado()
    {
        return $this->belongsTo('App\Encuestado', 'encuestado_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo('App\Item', 'item_id', 'id');
    }

    public function opcion()
    {
        return $this->belongsTo('App\Opcion', 'opcion_id', 'id');
    }

}
