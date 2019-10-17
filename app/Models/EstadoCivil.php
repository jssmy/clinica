<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    //
    protected $guarded=['id'];
    protected $table='estado_civil';
    public $timestamps=false;

    public function getesActivoAttribute() : bool {
        return  !! $this->estado;
    }
    public function scopeActivo($query){
        return $query->where('estado',1);
    }
}
