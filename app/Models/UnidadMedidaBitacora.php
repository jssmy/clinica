<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UnidadMedidaBitacora extends Model
{
    //
    protected $table='unidad_medidas_bitacora';
    protected $guarded=['id','fecha_acccion','unidad_medida_id'];
    public $timestamps=false;

    public function usuario_accion(){
        return $this->hasOne(User::class,'id','usuario_accion_id');
    }

}
