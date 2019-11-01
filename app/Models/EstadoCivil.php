<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    //
    protected $guarded=['id'];
    protected $table='estado_civil';
    public $timestamps=false;

    public function getesActivoAttribute(){
        return  !! $this->estado;
    }
    public function scopeActivo($query){
        return $query->where('estado',1);
    }
    public function usuario(){
        return $this->hasOne(User::class,'id','usuario_id');
    }

    public function getfecRegistroAttribute(){
        return Carbon::parse($this->fecha_registro);
    }

    public function bitacora(){
        return $this->hasMany(EstadoCivilBitacora::class,'estado_civil_id','id');
    }
}
