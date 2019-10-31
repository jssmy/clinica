<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\QueryPatologiaAnormal;
use App\Models\Entity;
use App\Models\ExamenCab;
use App\Models\ExamenDet;
use App\Models\Insumo;
use App\Models\Persona;
use App\Models\RegistroAnalisis;
use App\Models\RestultadoAnalisis;
use App\Models\UnidadMedida;
use function foo\func;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    use QueryPatologiaAnormal;
    public function index($tipo_reporte,$tipo_persona=null){

        $personas = Persona::join(RegistroAnalisis::getTableName().' as analisis','analisis.empleado_id',Persona::getTableName().'.id')
                            ->join(RestultadoAnalisis::getTableName().' as resultado','resultado.analisis_id','analisis.id')
                            ->selectRaw("genero,numero_documento,nombre,apellido_paterno,apellido_materno,resultado.id as examen")->get();

        $endPersonas = collect();
        $charData= $personas;
        $endBarData=[];
        foreach ($charData as $persona){
            $dataPersonas = $charData->where('numero_documento',$persona->numero_documento);
            if($dataPersonas->isNotEmpty()){
                if( ! $endPersonas->where('numero_documento',$persona->numero_documento)->count()){
                    $firstPersona =$dataPersonas->first();
                    $endBarData[] = [
                        'name'=>$firstPersona->nombre_completo,
                        'points'=>$dataPersonas->count(),
                        'bullet'=>$firstPersona->genero=='M' ? 'https://cdn2.iconfinder.com/data/icons/medical-flat-icons-part-1/513/18-512.png' :'https://cdn4.iconfinder.com/data/icons/flat-medical/150/female-doctor-512.png',
                    ];
                    $firstPersona->cantidad = $dataPersonas->count();
                    $endPersonas->push($firstPersona);
                }
            }
        }
        return view('dashboard.index',compact('tipo_reporte','tipo_persona','endBarData','endPersonas'));
    }

    public function mostrarReporte(Persona $persona,$tipo_reporte){
        $tipo_reporte=strtolower($tipo_reporte);
        switch ($tipo_reporte){
            case 'paciente-atendido':
                return $this->reportePacienteAtendido($persona);
            case  'medico-examen-emision':
                return $this->reporteMedicoExamenesEmitidos($persona);
            case  'stock-insuno':
                return $this->reporteStockInsumo();

        }
    }

    public function reportePacienteAtendido(Persona $persona){

        $analisis = RegistroAnalisis::where('paciente_id',$persona->id)
                                    ->join(RestultadoAnalisis::getTableName().' as resultado','resultado.analisis_id',RegistroAnalisis::getTableName().'.id')
                                    ->join(ExamenCab::getTableName().' as tipo_examen','tipo_examen.id','resultado.examen_cab_id')
                                    ->join(ExamenDet::getTableName().' as sub_tipo_examen','sub_tipo_examen.id','resultado.examen_det_id')
                                    ->selectRaw("resultado.id,tipo_examen.nombre as tipo_examen,
                                                sub_tipo_examen.nombre as sub_tipo_examen,
                                                date_format(resultado.fecha_resultado,'%d/%m/%Y') as fecha_resultado,
                                                resultado.resultado as resultado,".RegistroAnalisis::getTableName().'.estado')
                                                ->get()->groupBy('tipo_examen');

        $analisis = $analisis->map(function ($registros){
            return $registros->groupBy('sub_tipo_examen');
        });

        $pieData = $analisis->flatten()->groupBy('sub_tipo_examen');
        $allAnalisis = $analisis->flatten();
        $endDataPie=[];
        foreach ($pieData as $sub_tipo  =>$value){
            $endDataPie[]=['country'=>(string)$sub_tipo,'litres'=>(float)$value->count()];
        }


        return view('dashboard.partials.reporte-paciente-atendido',compact('persona','analisis','endDataPie','allAnalisis'));
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
            $piedaData = $resultados->flatten();
            $endPieData=[];
            foreach ($piedaData as $data){
                $endPieData[]=['country'=>(string)$data->examen_sub_tipo,'litres'=>$data->cantidad_sub_tipo];
            }

        return view('dashboard.partials.reporte-medico-examen-emision',compact('persona','resultados','analisis','endPieData'));
    }

    public function reporteStockInsumo(Request $request){
        $insumos = Insumo::join(UnidadMedida::getTableName().' as medida','medida.id','unidad_medida_id')
                    ->join(ExamenDet::getTableName().' as sub_tipo_examen','sub_tipo_examen.insumo_id',Insumo::getTableName().'.id')
                    ->selectRaw(Insumo::getTableName().".nombre AS insumo,".Insumo::getTableName().".cantidad,medida.nombre as unidad,sub_tipo_examen.nombre as uso")
                    ->get();

        $insumos=$insumos->groupBy('insumo');
        $allInsumos = Insumo::activo()->get();

        $endBarData=[];
        foreach ($allInsumos as $insumo){
            $endBarData[]=['name'=>str_replace('"','',(string)$insumo->nombre),'points'=>$insumo->cantidad];
        }

        return view('dashboard.stock-insumo',compact('insumos','endBarData'));
    }

    public function reporteTiempoAtencion(Request $request){
        //$analisis = RegistroAnalisis::
        return view('dashboard.tiempo-atencion');

    }

    public function reportePatologiaAnormal(Request $request){

        if($request->ajax()){

            list($fecha_inicio,$fecha_fin) = explode('hasta',str_replace(" ","",$request->fecha_resultado));
            //$fecha_inicio = explode("-",$fecha_inicio);
            //$fecha_fin =explode("-",$fecha_fin);
            //$fecha_inicio_formated =    $fecha_inicio[2]."-".$fecha_inicio[1]."-".$fecha_inicio[0];
            //$fecha_fin_formated =       $fecha_fin[2]."-".$fecha_fin[1]."-".$fecha_fin[0];
            ///dd($request->numero_documento,$fecha_fin,$fecha_inicio);
            $patologias = self::getPatologias($request->numero_documento,$fecha_inicio,$fecha_fin);

            return view('dashboard.partials.reporte-patologia-anormal-table',compact('patologias'));
        }

        return view('dashboard.patologia-anormal');
    }



}
