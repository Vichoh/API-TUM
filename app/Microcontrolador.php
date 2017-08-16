<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Microcontrolador extends Model
{
    protected $table = 'microcontroladores';

   	protected $primaryKey = 'id';

   	protected $fillable = [

   		'nombre', 'temperatura', 'monoxido', 'radiacion', 'latitud', 'longitud'

   	];
}
