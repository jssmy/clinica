<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    //
    protected $fillable=['tipo_seguro_id','numero_historia_clinica','usuario_id'];
    public $incrementing=false;
    public $timestamps=false;
    protected $table='pacientes';
}
