<?php


namespace App\Http\Controllers\Traits;


trait QueryPatologiaAnormal
{
    public static function getPatologias(int $numero_dni, $fecha_inicio, $fecha_fin){

            $queryWhere = "";
            if(!$numero_dni) return false;
            else $queryWhere.=" and persona.numero_documento = ?";

            if(!self::esFecha($fecha_fin) && !self::esFecha($fecha_fin)) return false;


            if(!$fecha_fin && !$fecha_inicio) return false;
            else $queryWhere.=" and resultado.fecha_registro BETWEEN ? and ? ";


            return \DB::select("SELECT analisis.codigo,
                        CONCAT(if(ISNULL(persona.nombre),'',persona.nombre),' ',if(ISNULL(persona.apellido_paterno),'',persona.apellido_paterno),' ',if(ISNULL(persona.apellido_materno),' ',persona.apellido_materno)) AS paciente,
                        tipo_examen.nombre AS tipo_examen,
                        sub_tipo_examen.nombre AS sub_tipo_examen,
                        resultado.resultado,
                        resultado.comentario AS observacion
                        FROM personas AS persona 
                        INNER JOIN registro_analisis AS analisis ON persona.id=analisis.paciente_id
                        INNER JOIN analisis_tipo_examen AS resultado ON resultado.analisis_id=analisis.id
                        INNER JOIN examen_cab AS tipo_examen ON tipo_examen.id=resultado.examen_cab_id
                        INNER JOIN examen_det AS sub_tipo_examen ON sub_tipo_examen.id=resultado.examen_det_id
                        WHERE  resultado.comentario IS NOT NULL and persona.tipo_persona='paciente' $queryWhere
                        ORDER BY 2,3",[$numero_dni,$fecha_inicio,$fecha_fin]);
    }

    private static function esFecha($fecha){
        return preg_match('/\d{4}-\d{2}-\d{2}/', $fecha);
    }
}
