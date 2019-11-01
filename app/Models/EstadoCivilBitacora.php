<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 31/10/2019
 * Time: 22:32
 */

namespace App\Models;


use App\User;

class EstadoCivilBitacora extends Entity
{
    public $timestamps=false;
    protected $table='estado_civil_bitacora';
    protected $guarded=['id'];
    public function usuario_accion(){
        return $this->hasOne(User::class,'id','usuario_accion_id');
    }
}
