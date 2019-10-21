<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ExamenCab extends Model
{
    //
    protected $guarded=['id'];
    protected $table='examen_cab';
    public $timestamps=false;
    public function getesActivoAttribute()  {
        return  !! $this->estado;
    }

    public function scopeActivo($query){
        return $query->where('estado',1);
    }

    public function usuario(){
        return $this->hasOne(User::class,'id','usuario_id');
    }

    public function getfecRegistroAttribute()
    {

        return Carbon::parse($this->fecha_registro);
    }

}
