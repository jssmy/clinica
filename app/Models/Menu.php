<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 27/10/2019
 * Time: 18:38
 */

namespace App\Models;


class Menu extends Entity
{
    protected $table='menus';

    public function scopeVisible($query)
    {
        return $query->where('estado', 1);
    }

    public function subMenu()
    {
        return $this->hasMany(Menu::class, 'padre_id', 'id');
    }

    public function scopePadre($query){
        return $query->whereNull('padre_id');
    }

    public function scopeHijo($query){
        return $query->whereNotNull('padre_id');
    }
    public function gethasSubMenuAttribute()
    {
        return !! $this->subMenu->count();
    }

}
