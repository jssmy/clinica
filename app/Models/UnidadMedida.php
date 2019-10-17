<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    //
    protected $table='unidad_medidas';
    protected $guarded=['id','fecha_registro','fecha_actualizacion'];
    public $timestamps=false;

    public function getesActivoAttribute() : bool {
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

}