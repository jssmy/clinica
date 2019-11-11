<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 31/10/2019
 * Time: 19:22
 */

namespace App\Http\Controllers\Traits;


use App\Models\ExamenCab;
use App\Models\ExamenDet;
use Illuminate\Support\Facades\DB;

trait QueryProduccionMensual
{
    public static function getProduccion($tipo_examen){
        $params =[];
        $where="";
        if($tipo_examen){
            array_push($params,$tipo_examen);
            $where="and cab.id = ?";
        }

        $results = DB::select("SELECT
                            IFNULL(a.Mes,DATE_FORMAT(NOW(),'%M')) AS MES,
                            cab.nombre AS TipoExamen, det.nombre AS SubTipoExamen,
                            IFNULL(a.Pagantes,'-') AS PAGANTES,
                            IFNULL(a.SIS,'-') AS SIS
                            FROM examen_det det
                            INNER JOIN examen_cab cab ON cab.id = det.examen_cab_id
                            LEFT JOIN view_produccion_mensual a ON a.examen_cab_id = cab.id and a.examen_det_id = det.id
                            where 1=1 $where
                            ORDER BY cab.nombre, det.nombre",$params);
        return collect($results)->map(function ($item){
            return (object)$item;
        });

    }
}
