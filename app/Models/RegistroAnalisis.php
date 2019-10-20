<?php

namespace App\Models;

use App\User;
use Faker\Provider\Person;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class RegistroAnalisis extends Model
{
    //
    protected $table='registro_analisis';
    public $timestamps=false;
    protected $guarded=['id'];

    public function paciente(){
        return $this->hasOne(Persona::class,'id','paciente_id');
    }

    public function medico(){
        return $this->hasOne(Persona::class,'id','empleado_id');
    }

    public function usuario(){
        return $this->hasOne(User::class,'id','usuario_id');
    }

}
