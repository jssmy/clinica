<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    //
    protected $fillable=['id','descripcion','estado','usuario_id'];
    protected $table='perfiles';
    public $incrementing=false;
    public $timestamps=false;

    public function getesActivoAttribute()  {
        return  !! $this->estado;
    }

    public function usuario(){
        return $this->hasOne(User::class,'id','usuario_id');
    }

    public function getfecRegistroAttribute()
    {
        return Carbon::parse($this->fecha_registro);
    }

    public function scopeActivo($query){
        return $query->where('estado',1);
    }

    public function menus()
    {
        return $this->belongsToMany( Menu::class, 'accesos', 'perfil_id');
    }

}
