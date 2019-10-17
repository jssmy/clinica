<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamenDet extends Model
{
    //
    protected $guarded=['id'];
    protected $table='examen_det';
    public $timestamps=false;

    public function getesActivoAttribute(){
        return !! $this->estado;
    }

    public function scopeActivo($query){
        return $query->where('estado',1);
    }
}
