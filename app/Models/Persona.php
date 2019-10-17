<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    //
    protected $table='personas';
    protected $guarded=['id'];
    public $timestamps=false;

    public function getnombreCompletoAttribute(){
        return $this->nombre." ".$this->apellido_paterno." ".$this->apellido_materno;
    }
    public function  getgeneroCompletoAttribute($key){
        return strtolower($this->genero) =='m' ? 'Hombre' : 'Mujer';
    }

    public function paciente(){
        return $this->hasOne(Paciente::class,'persona_id','id');
    }
    public function empleado(){
            return $this->hasOne(Empleado::class,'persona_id','id');
    }


    public function getesPacienteAttribute(){
        return $this->tipo_persona=='paciente';
    }
    public function getesHombreAttribute(){
        return $this->genero=='M';
    }
    public function scopeSoloPaciente($query){
        return $query->where('tipo_persona','paciente');
    }
    public function scopeSoloMedico($query){
        return $query->where('tipo_persona','empleado');
    }

}