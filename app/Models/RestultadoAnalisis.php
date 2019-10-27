<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RestultadoAnalisis extends Model
{
    //
    protected $table='analisis_tipo_examen';
    protected $guarded=['id','fecha_registro'];
    public $timestamps=false;

    public function getfechaRegistroAttribute(){
        return Carbon::parse($this->getOriginal('fecha_registro'));
    }

    public function usuario(){
        return $this->hasOne(User::class,'id','usuario_id');
    }

    public function tipoExamen(){
        return $this->hasOne(ExamenCab::class,'id','examen_cab_id');
    }
    public function subTipoExamen(){
        return $this->hasOne(ExamenDet::class,'id','examen_det_id');
    }

    public function analisis(){
        return $this->hasOne(RegistroAnalisis::class,'id','analisis_id');
    }


}
