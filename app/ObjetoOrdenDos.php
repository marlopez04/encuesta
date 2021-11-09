<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjetoOrdenDos extends Model
{
    protected $fillable = ['id','descripcion', 'favorable', 'neutro', 'desfavorable'];
}
