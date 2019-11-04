<?php

namespace App;

use App\Models\Perfil;
use App\Models\Persona;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table='usuarios';
    public $timestamps=false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded=['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function persona(){
        return $this->hasOne(Persona::class,'id','persona_id');
    }
    public function perfil(){
        return $this->hasOne(Perfil::class,'id','perfil_id');
    }

    public function usuario_registro(){
        return $this->hasOne(User::class,'id','usuario_id');
    }

    public function getesAdministradorAttribute()
    {
        return strtolower($this->peril_id)=='adm';
    }

    public function getesTecnologoAttribute(){
     return strtolower($this->perfil_id)=='tec';
    }
}
