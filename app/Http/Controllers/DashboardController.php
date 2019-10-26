<?php

namespace App\Http\Controllers;

use App\Models\ExamenCab;
use App\Models\ExamenDet;
use App\Models\Persona;
use App\Models\RegistroAnalisis;
use App\Models\RestultadoAnalisis;
use function foo\func;

class DashboardController extends Controller
{
    //

    public function index($tipo_reporte,$tipo_persona){

        return view('dashboard.index',compact('tipo_reporte','tipo_persona'));
    }

    public function mostrarReporte(Persona $persona,$tipo_reporte){
        $tipo_reporte=strtolower($tipo_reporte);
        switch ($tipo_reporte){
            case 'paciente-atendido':
                return $this->reportePacienteAtendido($persona);
            case  'medico-examen-emision':
                return $this->reporteMedicoExamenesEmitidos($persona);

        }
    }

    public function reportePacienteAtendido(Persona $persona){
        $analisis = $persona->analisis;
        $analisis = $analisis->load(['resultados.tipoExamen','resultados.subTipoExamen']);
        $analisis=$analisis->filter(function ($registro){
            if(!$registro->resultados->isEmpty()){
                return $registro;
            }
        })->sortByDesc('fecha_registro');

        return view('dashboard.partials.reporte-paciente-atendido',compact('persona','analisis'));
    }

    public function reporteMedicoExamenesEmitidos(Persona $persona){
        $analisis = $persona->analisis;

        $resultados=RegistroAnalisis::join(RestultadoAnalisis::getTableName().' as resultado','resultado.analisis_id',RegistroAnalisis::getTableName().'.id')
            ->join(ExamenCab::getTableName().' as tipo_examen','tipo_examen.id','resultado.examen_cab_id')
            ->join(ExamenDet::getTableName().' as sub_tipo_examen','sub_tipo_examen.id','resultado.examen_det_id')
            ->where('empleado_id',$persona->id)
            ->selectRaw('tipo_examen.nombre as examen_tipo,sub_tipo_examen.nombre as examen_sub_tipo,count(1) as cantidad_sub_tipo')
            ->groupBy(['tipo_examen.nombre','sub_tipo_examen.nombre'])
            ->get();
            $resultados =$resultados->groupBy('examen_tipo');
            //dd($analisis->where('estado','AP'));
        return view('dashboard.partials.reporte-medico-examen-emision',compact('persona','resultados','analisis'));
    }

}
