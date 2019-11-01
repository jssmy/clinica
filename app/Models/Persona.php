<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Persona extends Entity
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

    public function getfecNacimientoAttribute()
    {
        return Carbon::parse($this->fecha_nacimiento);
    }

    public function getfecRegistroAttribute()
    {
        return Carbon::parse($this->fecha_registro);
    }
    public function analisis(){
        if($this->es_paciente){
            return $this->hasMany(RegistroAnalisis::class,'paciente_id','id');
        }
        return $this->hasMany(RegistroAnalisis::class,'empleado_id','id');
    }

    public function estadoCivil(){
        return$this->hasOne(EstadoCivil::class,'id','estado_civil_id');
    }

    public function usuario(){
        return $this->hasOne(User::class,'persona_id','id');
    }

    public function usuario_accion(){
        return $this->hasOne(User::class,'id','usuario_id');
    }

    public function scopeSoloTecnologo($query){
        if(request()->tipo=='tecnologo'){
            $query->whereHas('usuario',function ($q){
                $q->where('id','TEC');
            });
        }
        return $query;
    }




}
