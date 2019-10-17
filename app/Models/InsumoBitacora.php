<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsumoBitacora extends Model
{
    //
    protected $table='insumos_bitacora';
    protected $guarded=['id','fecha_accion'];
    public $timestamps=false;
}
