<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\RestultadoAnalisis;
use function foo\func;

class DashboardController extends Controller
{
    //

    public function index($tipo_reporte){
        return view('dashboard.index',compact('tipo_reporte'));
    }

    public function mostrarReporte(Persona $persona,$tipo_reporte){
        $tipo_reporte=strtolower($tipo_reporte);
        switch ($tipo_reporte){
            case 'paciente-atendido':
                return $this->reportePacienteAtendido($persona);
            case  '':


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

}
