<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TipoSeguroBitacora extends Model
{
    //
    protected $table='tipo_seguros_bitacora';
    protected $guarded=['id'];
    public $timestamps=false;

    public function usuario_accion(){
        return $this->hasOne(User::class,'id','usuario_accion_id');
    }
}
