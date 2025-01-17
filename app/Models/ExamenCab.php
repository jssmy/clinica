<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ExamenCab extends Entity
{
    //
    protected $guarded=['id'];
    protected $table='examen_cab';
    public $timestamps=false;
    public function getesActivoAttribute()  {
        return  !! $this->estado;
    }
    public function scopeporPerfil($query){
        if(!auth()->user()->EsAdministrador && !auth()->user()->esMedicoJefe){
            return $query->where('id',1);
        }
        return $query;
    }
    public function scopeActivo($query){
        return $query->where('estado',1);
    }

    public function usuario(){
        return $this->hasOne(User::class,'id','usuario_id');
    }

    public function getfecRegistroAttribute()
    {
        return Carbon::parse($this->fecha_registro);
    }

    public function bitacora(){
        return $this->hasMany(ExamenCabBitacora::class,'examen_cab_id','id');
    }

    public function insumos(){
        return $this->hasMany(Insumo::class,'examen_cab_id','id');
    }

}
