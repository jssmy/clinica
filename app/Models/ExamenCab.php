<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamenCab extends Model
{
    //
    protected $guarded=['id'];
    protected $table='examen_cab';
    public $timestamps=false;
    public function getesActivoAttribute() : bool {
        return  !! $this->estado;
    }

    public function scopeActivo($query){
        return $query->where('estado',1);
    }

}
