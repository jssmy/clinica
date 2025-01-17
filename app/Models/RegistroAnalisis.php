<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Faker\Provider\Person;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class RegistroAnalisis extends Entity
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

    public  static function generarCodigo(){
        $sufijo = self::selectRaw('max(id) as numero')->first();
        $sufijo = $sufijo ? $sufijo->numero : 0;
        return "RC-".str_pad($sufijo,9,'0',STR_PAD_LEFT)."-".date('Y');
    }

    public function getfecRegistroAttribute()
    {
        return Carbon::parse($this->fecha_registro);
    }

    public function resultados(){
        return $this->hasMany(RestultadoAnalisis::class,'analisis_id','id');
    }

    public function getaprobadoAttribute()
    {
        return  $this->resultados()->whereNull('resultado')->count() == 0 ? true : false;
    }
    public function getesAprobadoAttribute()
    {
        return $this->estado=='AP';
    }

}
