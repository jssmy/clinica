<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 10/11/2019
 * Time: 21:08
 */

namespace App\Http\Controllers\Traits;


use App\Models\Persona;
use App\Models\RegistroAnalisis;
use App\Models\RestultadoAnalisis;
use App\User;

trait QueryProfesionalMedico
{
    public static function getProfesional(){
        $colum = \request()->tecnologo ? 'usuario_resultado_id' :'empleado_id';
        $personas = (new Persona());
        if(\request()->tecnologo){
            $personas = $personas->join((new User())->getTable()." as usuario",'usuario.persona_id',Persona::getTableName().".id")
                ->join(RegistroAnalisis::getTableName().' as analisis',"analisis.usuario_resultado_id",'usuario.id');
        }else{
            $personas=$personas->join(RegistroAnalisis::getTableName().' as analisis',"analisis.empleado_id",Persona::getTableName().'.id');
        }

        $personas = $personas->join(RestultadoAnalisis::getTableName().' as resultado','resultado.analisis_id','analisis.id')
            ->selectRaw("genero,numero_documento,nombre,apellido_paterno,apellido_materno,resultado.id as examen");
        if(!\request()->numero_documento && \request()->fecha_registro){

            list($fecha_inicio,$fecha_fin) = explode('/',str_replace([' ','hasta'],['','/'],\request()->fecha_registro));
            if(\request()->tecnologo){
                $personas = $personas->whereRaw('analisis.fecha_resultado >= ? and analisis.fecha_resultado <= ?',[$fecha_inicio,$fecha_fin]);
            }else {
                $personas = $personas->whereRaw('analisis.fecha_registro >= ? and analisis.fecha_registro <= ?',[$fecha_inicio,$fecha_fin]);
            }

        }
        return $personas->get();
    }

}
