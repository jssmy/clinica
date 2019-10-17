<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable=['numero_colegiatura','perfil_id','usuario_id'];
    public $incrementing=false;
    public $timestamps=false;
    protected $table='empleados';
}
