<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class InsumoBitacora extends Model
{
    //
    protected $table='insumos_bitacora';
    protected $guarded=['id','fecha_accion'];
    public $timestamps=false;
    public function usuario_accion(){
        return $this->hasOne(User::class,'id','usuario_accion_id');
    }
    public function medida(){
        return $this->hasOne(UnidadMedida::class,'id','unidad_medida_id');
    }
}
