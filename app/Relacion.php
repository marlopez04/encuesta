<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relacion extends Model
{

    protected $table = "relacion";
    protected $fillable = ['indice_id','dimension_id','factor_id','item_id',];

    public function indice()
    {
    	return $this->belongsTo('App\Indice', 'indice_id', 'id');
    }

    public function dimension()
    {
    	return $this->belongsTo('App\Dimension', 'dimension_id', 'id');
    }

    public function factor()
    {
    	return $this->belongsTo('App\Factor', 'factor_id', 'id');
    }

    public function item()
    {
    	return $this->belongsTo('App\Factor', 'item_id', 'id');
    }

}
