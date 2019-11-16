<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 10/11/2019
 * Time: 21:14
 */

namespace App\Http\Controllers\Traits;


use App\Models\ExamenCab;
use App\Models\ExamenDet;
use App\Models\Persona;
use App\Models\RegistroAnalisis;
use App\Models\RestultadoAnalisis;

trait QueryExamenEmision
{
    public static function getEmision($persona){
        $persona_id= $persona->id;
        $column=RegistroAnalisis::getTableName().".empleado_id";
        if(request()->tecnologo){
            $persona_id = $persona->usuario->id;
            $column=RegistroAnalisis::getTableName().".usuario_resultado_id";
        }

        $resultados=RegistroAnalisis::join(RestultadoAnalisis::getTableName().' as resultado','resultado.analisis_id',RegistroAnalisis::getTableName().'.id')
            ->join(ExamenCab::getTableName().' as tipo_examen','tipo_examen.id','resultado.examen_cab_id')
            ->join(ExamenDet::getTableName().' as sub_tipo_examen','sub_tipo_examen.id','resultado.examen_det_id')
            ->whereRaw("$column=?",[$persona_id])
            ->selectRaw('tipo_examen.nombre as examen_tipo,sub_tipo_examen.nombre as examen_sub_tipo,count(1) as cantidad_sub_tipo')
            ->groupBy(['tipo_examen.nombre','sub_tipo_examen.nombre']);

        if(request()->fecha_registro){

            list($fecha_inicio,$fecha_fin) = explode('/',str_replace([' ','hasta'],['','/'],\request()->fecha_registro));
            $resultados = $resultados->whereRaw('registro_analisis.fecha_registro>= ? and registro_analisis.fecha_registro <= ?',[$fecha_inicio,$fecha_fin]);
        }
        return $resultados->get();
    }

    public static function getAnalisis($persona){
        $persona_id= $persona->id;

        if(request()->tecnologo){
            $analisis = $persona->analisisTecnologo;
        }else {
            $analisis = $persona->analisis;
        }

        if(request()->fecha_registro){
            list($fecha_inicio,$fecha_fin) = explode('/',str_replace([' ','hasta'],['','/'],\request()->fecha_registro));
            $analisis = $analisis->where('fecha_registro','>=',$fecha_inicio)->where('fecha_registro','<=',$fecha_fin);
        }
        return $analisis;
    }
}

