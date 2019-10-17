<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadMedidaBitacora extends Model
{
    //
    protected $table='unidad_medidas_bitacora';
    protected $guarded=['id','fecha_acccion','unidad_medida_id'];
    public $timestamps=false;

}
