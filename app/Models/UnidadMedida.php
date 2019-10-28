<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Entity
{
    //
    protected $table='unidad_medidas';
    protected $guarded=['id','fecha_registro','fecha_actualizacion'];
    public $timestamps=false;

    public function getesActivoAttribute(){
        return !! $this->estado;
    }

    public function getfechaRegistroAttribute(){
        return Carbon::parse($this->getOriginal('fecha_registro'));
    }

    public function bitacora(){
        return $this->hasMany(UnidadMedidaBitacora::class,'unidad_medida_id','id');
    }
    public function scopeActivo($query){
        return $query->where('estado',1);
    }

    public function usuario(){
        return $this->hasOne(User::class,'id','usuario_id');
    }

}
