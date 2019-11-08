<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    protected $table = "opcion";
    protected $fillable = ['codigo','opcion', 'puntaje', 'puntaje_neg'];


    public function item()
    {
        return $this->hasMany('App\Item');
    }
}
