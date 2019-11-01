<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 31/10/2019
 * Time: 13:47
 */

namespace App\Http\Controllers\Traits;


trait QueryTiemPromedioAtencion
{
        public static function getSolicitudes(int $numero_documento_paciente=0,
                                              int $numero_documento_medico=0,
                                              $fecha_inicio=null,
                                              $fecha_fin=null){
            $bindings=[];
            $where="";
            if($numero_documento_paciente){
                $where.=" and paciente.numero_documento=?";
                array_push($bindings,$numero_documento_paciente);
            }
            if($numero_documento_medico){
                $where.=" and medico.numero_documento=?";
                array_push($bindings,$numero_documento_medico);
            }
            if($fecha_fin && $fecha_inicio && self::esFecha($fecha_fin) && self::esFecha($fecha_inicio)){
                $where.=" and resultado.fecha_registro between ? and ?";
                array_push($bindings,$fecha_inicio);
                array_push($bindings,$fecha_fin);
            }

            return \DB::select("SELECT analisis.codigo,
                                tipo_examen.nombre AS tipo_examen,
                                sub_tipo_examen.nombre AS sub_tipo_examen,
                                DATE_FORMAT(resultado.fecha_registro,'%d/%m/%Y') AS fecha_registro, 
                                DATE_FORMAT(resultado.fecha_resultado,'%d/%m/%Y') AS fecha_resultado,
                                ROUND(TIMESTAMPDIFF(minute,resultado.fecha_registro,resultado.fecha_resultado)/60,2) AS diferencia
                                FROM registro_analisis AS analisis
                                INNER JOIN personas as paciente on paciente.id=analisis.paciente_id
                                INNER JOIN personas as medico on medico.id =analisis.empleado_id
                                INNER JOIN analisis_tipo_examen AS resultado ON resultado.analisis_id=analisis.id
                                INNER JOIN examen_cab AS tipo_examen ON tipo_examen.id=resultado.examen_cab_id
                                INNER JOIN examen_det AS sub_tipo_examen ON sub_tipo_examen.id=resultado.examen_det_id
                                WHERE analisis.estado='AP' $where                    
                                ORDER BY 1,2,3",$bindings);
        }


}
