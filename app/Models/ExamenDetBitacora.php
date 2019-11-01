<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 31/10/2019
 * Time: 20:06
 */

namespace App\Models;


use App\User;

class ExamenDetBitacora extends Entity
{
    protected $table='examen_det_bitacora';
    public $timestamps=false;
    protected $guarded=['id'];

    public function usuario_accion(){
        return $this->hasOne(User::class,'id','usuario_accion_id');
    }

}
