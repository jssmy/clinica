<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 31/10/2019
 * Time: 20:42
 */

namespace App\Models;


use App\User;

class ExamenCabBitacora extends  Entity
{
    public $timestamps=false;
    protected $guarded=['id'];
    protected $table='examen_cab_bitacora';

    public function usuario_accion(){
        return $this->hasOne(User::class,'id','usuario_accion_id');
    }
}
