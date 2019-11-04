<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ExamenDet extends Entity
{
    //
    protected $guarded=['id'];
    protected $table='examen_det';
    public $timestamps=false;

    public function getesActivoAttribute(){
        return !! $this->estado;
    }

    public function scopeActivo($query){
        return $query->where('estado',1);
    }

    public function insumo(){
        return $this->hasOne(Insumo::class,'examen_det_id','id');
    }

    public function usuario(){
        return $this->hasOne(User::class,'id','usuario_id');
    }
    public function getfecRegistroAttribute()
    {
        return Carbon::parse($this->fecha_registro);
    }
    public function bitacora(){
        return $this->hasMany(ExamenDetBitacora::class,'examen_det_id','id');
    }

    public function tipo_examen(){
        return $this->hasOne(ExamenCab::class,'id','examen_cab_id');
    }

}
