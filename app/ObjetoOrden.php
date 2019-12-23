<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjetoOrden extends Model
{
    protected $fillable = ['id','descripcion', 'favorabilidad', 'cantidad', 'porcentage'];
}
