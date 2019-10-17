<?php

namespace App\Observers;

use App\Models\TipoSeguro;

class TipoSeguroObserver
{
    //
    public function saved(TipoSeguro $item){
        $item->bitacora()->create([
            'nombre'=>$item->nombre,
            'descripcion'=>$item->descripcion,
            'usuario_id'=>$item->usuario_id,
            'estado'=>$item->estado,
            'fecha_registro'=>$item->fecha_registro,
            'usuario_accion_id'=> 1212,
        ]);
    }

    /*
    public function saving(TipoSeguro $item){
        dd($item);
        $item->bitacora()->create([
            'nombre'=>$item->nombre,
            'descripcion'=>$item->descripcion,
            'usuario_id'=>$item->usuario_id,
            'estado'=>$item->estado,
            'fecha_registro'=>$item->fecha_registro,
            'usuario_accion_id'=> 1212,
        ]);
    }
    */
}
