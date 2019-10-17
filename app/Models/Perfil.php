<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    //
    protected $fillable=['id','descripcion','estado','usuario_id'];
    protected $table='perfiles';
    public $incrementing=false;
    public $timestamps=false;

    public function getesActivoAttribute() : bool {
        return  !! $this->estado;
    }

}
