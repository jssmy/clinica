<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 10/11/2019
 * Time: 21:53
 */

namespace App\Http\Controllers\Traits;


use App\Models\ExamenDet;
use App\Models\Insumo;
use App\Models\UnidadMedida;

trait QueryStockInsumo
{
    public static function getStock($request){
        $insumos = Insumo::join(UnidadMedida::getTableName().' as medida','medida.id','unidad_medida_id')
            ->leftJoin(ExamenDet::getTableName().' as sub_tipo_examen','sub_tipo_examen.id',Insumo::getTableName().'.examen_det_id')
            ->selectRaw(Insumo::getTableName().".nombre AS insumo,".Insumo::getTableName().".cantidad,medida.nombre as unidad,sub_tipo_examen.nombre as uso");

        if($request->stock) $insumos = $insumos->where(Insumo::getTableName().".cantidad","<=",$request->stock);

        return $insumos->get();
    }
}
