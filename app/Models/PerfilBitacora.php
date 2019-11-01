<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 31/10/2019
 * Time: 21:16
 */

namespace App\Models;


use App\User;

class PerfilBitacora extends Entity
{
    public $timestamps=false;
    protected $table='perfiles_bitacora';
    protected $guarded=['id'];
    public function usuario_accion(){
        return $this->hasOne(User::class,'id','usuario_accion_id');
    }

}
