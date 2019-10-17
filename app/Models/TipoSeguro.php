<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TipoSeguro extends Model
{
    //
    protected $table='tipo_seguros';
    protected $guarded=['id'];
    public $timestamps=false;

    public function getesActivoAttribute() : bool {
            return  !! $this->estado;
    }

    public function getfechaRegistroAttribute()
    {
        return Carbon::parse($this->getOriginal('fecha_registro'));
    }

    public function bitacora(){
        return $this->hasMany(TipoSeguroBitacora::class,'tipo_seguro_id','id');
    }
    public function scopeActivo($query){
        return $query->where('estado',1);
    }




}
