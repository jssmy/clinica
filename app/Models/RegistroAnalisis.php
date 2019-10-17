<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroAnalisis extends Model
{
    //
    protected $table='registro_analisis';
    public $timestamps=false;
    protected $guarded=['id'];

    public function paciente(){
        return $this->hasOne(Persona::class,'paciente_id','id');
    }

    public function medico(){
        return $this->hasOne(Persona::class,'empleado_id','id');
    }

}
