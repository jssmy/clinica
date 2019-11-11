<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 10/11/2019
 * Time: 20:17
 */

namespace App\Http\Controllers\Traits;


use App\Models\ExamenCab;
use App\Models\ExamenDet;
use App\Models\RegistroAnalisis;
use App\Models\RestultadoAnalisis;

trait QueryPacienteAtendido
{
    public static function getAtencion($paciente_id){
        return $analisis = RegistroAnalisis::where('paciente_id',$paciente_id)
            ->join(RestultadoAnalisis::getTableName().' as resultado','resultado.analisis_id',RegistroAnalisis::getTableName().'.id')
            ->join(ExamenCab::getTableName().' as tipo_examen','tipo_examen.id','resultado.examen_cab_id')
            ->join(ExamenDet::getTableName().' as sub_tipo_examen','sub_tipo_examen.id','resultado.examen_det_id')
            ->selectRaw("resultado.id,tipo_examen.nombre as tipo_examen,
                                                sub_tipo_examen.nombre as sub_tipo_examen,
                                                date_format(resultado.fecha_resultado,'%d/%m/%Y') as fecha_resultado,
                                                resultado.resultado as resultado,".RegistroAnalisis::getTableName().'.estado')
                                                ->get()->groupBy('tipo_examen');
    }
}
