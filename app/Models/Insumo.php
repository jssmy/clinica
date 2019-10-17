<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    //
    protected $guarded=['id','fecha_registro'];
    protected $table='insumos';
    public $timestamps=false;

    public function getesActivoAttribute() : bool {
        return  !! $this->estado;
    }

    public function getfechaRegistroAttribute()
    {
        return Carbon::parse($this->getOriginal('fecha_registro'));
    }
    public function scopeActivo($query){
        $query->where('estado',1);
    }

    public function bitacora(){
        return $this->hasMany(InsumoBitacora::class,'insumo_id','id');
    }
    public function medida(){
        return $this->hasOne(UnidadMedida::class,'id','unidad_medida_id');
    }
}