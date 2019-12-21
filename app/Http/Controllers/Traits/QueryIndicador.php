<?php


namespace App\Http\Controllers\Traits;


trait QueryIndicador
{

    public static function getUno($fecha_inicio,$fecha_fin){
        $params = [];
        $queryWhere = "";
            if($fecha_inicio){
                $queryWhere= " and res.Fecha_Registro>='$fecha_inicio'";
            }
            if($fecha_fin){
            $queryWhere.= " and res.Fecha_Registro<='$fecha_fin'";
            }

            $resultados =\DB::select("SELECT DATE_FORMAT(res.Fecha_Registro,\"%d/%m/%Y\") as fecha_registro,
                    COUNT(res.analisis_id) AS cantidad_resultado,
                    ROUND(240/COUNT(res.analisis_id)) AS TP
                    FROM(
                        SELECT SUBSTRING(fecha_resultado, 1,10) AS Fecha_Registro, analisis_id 
                        FROM analisis_tipo_examen 
                        WHERE fecha_resultado IS NOT NULL 
                        GROUP BY SUBSTRING(fecha_resultado, 1,10),analisis_id) res where 1=1  $queryWhere GROUP BY res.Fecha_Registro");
            $resultados = array_map(function ($resultado){
                return (object) $resultado;
            },$resultados);
            return $resultados;
    }

    public static function getDos($fecha_inicio,$fecha_fin){
        $quereyWhere = "";
        if($fecha_inicio){
            $quereyWhere= " and a.F_Reg_Analisis>='$fecha_inicio'";
        }
        if($fecha_fin) {
            $quereyWhere.=" and a.F_Reg_Analisis<='$fecha_fin'";
        }
        $resultados = \DB::select("SELECT DATE_FORMAT(a.F_Reg_Analisis,\"%d/%m/%Y\") AS fecha_registro ,a.Cant_Registrios as cantidad_registros,b.Cant_Resultado as cantidad_resultado,
                    CONCAT(ROUND((b.Cant_Resultado/a.Cant_Registrios)*100),' %') AS POC  
                            FROM (
                                SELECT 
                                SUBSTRING(fecha_registro, 1,10) as F_Reg_Analisis, COUNT(id) AS Cant_Registrios
                                FROM registro_analisis 
                                GROUP BY SUBSTRING(fecha_registro, 1,10)
                            ) a
                            LEFT JOIN (
                                SELECT res.Fecha_Registro as F_Reg_Resultado,COUNT(res.analisis_id) AS Cant_Resultado 
                                FROM(
                                    SELECT SUBSTRING(fecha_resultado, 1,10) AS Fecha_Registro, analisis_id 
                                    FROM analisis_tipo_examen 
                                    WHERE fecha_resultado IS NOT NULL
                                    GROUP BY SUBSTRING(fecha_resultado, 1,10),analisis_id 
                                )res
                                GROUP BY res.Fecha_Registro
                            )b ON b.F_Reg_Resultado = a.F_Reg_Analisis
                            where 1=1 $quereyWhere
                            ORDER BY a.F_Reg_Analisis");

        $resultados = array_map(function ($resultado){
            return (object) $resultado;
        },$resultados);
        return $resultados;
    }
}
