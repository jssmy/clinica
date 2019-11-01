<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\QueryPatologiaAnormal;
use App\Http\Controllers\Traits\QueryTiemPromedioAtencion;
use App\Models\Entity;
use App\Models\ExamenCab;
use App\Models\ExamenDet;
use App\Models\Insumo;
use App\Models\Perfil;
use App\Models\Persona;
use App\Models\RegistroAnalisis;
use App\Models\RestultadoAnalisis;
use App\Models\UnidadMedida;
use App\Services\ExcelService;
use App\User;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    use QueryPatologiaAnormal;
    use QueryTiemPromedioAtencion;

    private  static function esFecha($fecha){
        return preg_match('/\d{4}-\d{2}-\d{2}/', $fecha);
    }

    public function index($tipo_reporte,$tipo_persona=null){
        $personas = Persona::join(RegistroAnalisis::getTableName().' as analisis','analisis.empleado_id',Persona::getTableName().'.id')
                            ->join(RestultadoAnalisis::getTableName().' as resultado','resultado.analisis_id','analisis.id')
                            ->selectRaw("genero,numero_documento,nombre,apellido_paterno,apellido_materno,resultado.id as examen");

        if(\request()->tipo=='tecnologo'){
            $personas = $personas->join((new User())->getTable().' as usuario','usuario.persona_id',Persona::getTableName().'.id')
                        ->where('usuario.id','TEC');
        }


        $personas = $personas->get();
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
                return $this->reportePacienteAtendido($persona,$tipo_reporte);
            case  'medico-examen-emision':
                return $this->reporteMedicoExamenesEmitidos($persona,$tipo_reporte);
            case  'stock-insuno':
                return $this->reporteStockInsumo();

        }
    }

    public function reportePacienteAtendido(Persona $persona,$tipo_reporte){

        $analisis = RegistroAnalisis::where('paciente_id',$persona->id)
                                    ->join(RestultadoAnalisis::getTableName().' as resultado','resultado.analisis_id',RegistroAnalisis::getTableName().'.id')
                                    ->join(ExamenCab::getTableName().' as tipo_examen','tipo_examen.id','resultado.examen_cab_id')
                                    ->join(ExamenDet::getTableName().' as sub_tipo_examen','sub_tipo_examen.id','resultado.examen_det_id')
                                    ->selectRaw("resultado.id,tipo_examen.nombre as tipo_examen,
                                                sub_tipo_examen.nombre as sub_tipo_examen,
                                                date_format(resultado.fecha_resultado,'%d/%m/%Y') as fecha_resultado,
                                                resultado.resultado as resultado,".RegistroAnalisis::getTableName().'.estado')
                                                ->get()->groupBy('tipo_examen');

        if(\request()->download){
            $header = array_keys($analisis->flatten()->first()->toArray());
            ExcelService::create($header,$analisis->flatten()->toArray());
            exit;
        }
        $analisis = $analisis->map(function ($registros){
            return $registros->groupBy('sub_tipo_examen');
        });

        $pieData = $analisis->flatten()->groupBy('sub_tipo_examen');
        $allAnalisis = $analisis->flatten();
        $endDataPie=[];
        foreach ($pieData as $sub_tipo  =>$value){
            $endDataPie[]=['country'=>(string)$sub_tipo,'litres'=>(float)$value->count()];
        }

        return view('dashboard.partials.reporte-paciente-atendido',compact('persona','analisis','endDataPie','allAnalisis','tipo_reporte'));
    }

    public function reporteMedicoExamenesEmitidos(Persona $persona,$tipo_reporte){
        $analisis = $persona->analisis;

        $resultados=RegistroAnalisis::join(RestultadoAnalisis::getTableName().' as resultado','resultado.analisis_id',RegistroAnalisis::getTableName().'.id')
            ->join(ExamenCab::getTableName().' as tipo_examen','tipo_examen.id','resultado.examen_cab_id')
            ->join(ExamenDet::getTableName().' as sub_tipo_examen','sub_tipo_examen.id','resultado.examen_det_id')
            ->where('empleado_id',$persona->id)
            ->selectRaw('tipo_examen.nombre as examen_tipo,sub_tipo_examen.nombre as examen_sub_tipo,count(1) as cantidad_sub_tipo')
            ->groupBy(['tipo_examen.nombre','sub_tipo_examen.nombre'])
            ->get();

        if(\request()->download){
            $header = array_keys($resultados->first()->toArray());
            ExcelService::create($header,$resultados->toArray());
            exit;
        }
            $resultados =$resultados->groupBy('examen_tipo');
            $piedaData = $resultados->flatten();
            $endPieData=[];
            foreach ($piedaData as $data){
                $endPieData[]=['country'=>(string)$data->examen_sub_tipo,'litres'=>$data->cantidad_sub_tipo];
            }

        return view('dashboard.partials.reporte-medico-examen-emision',compact('persona','resultados','analisis','endPieData','tipo_reporte'));
    }

    public function reporteStockInsumo(Request $request){
        $insumos = Insumo::join(UnidadMedida::getTableName().' as medida','medida.id','unidad_medida_id')
                    ->join(ExamenDet::getTableName().' as sub_tipo_examen','sub_tipo_examen.insumo_id',Insumo::getTableName().'.id')
                    ->selectRaw(Insumo::getTableName().".nombre AS insumo,".Insumo::getTableName().".cantidad,medida.nombre as unidad,sub_tipo_examen.nombre as uso")
                    ->get();

        if($request->download){
            ExcelService::create(array_keys($insumos->first()->toArray()),$insumos->toArray());
            exit;
        }
        $insumos=$insumos->groupBy('insumo');
        $allInsumos = Insumo::activo()->get();

        $endBarData=[];
        foreach ($allInsumos as $insumo){
            $endBarData[]=['name'=>str_replace('"','',(string)$insumo->nombre),'points'=>$insumo->cantidad];
        }

        return view('dashboard.stock-insumo',compact('insumos','endBarData'));
    }

    public function reportePatologiaAnormal(Request $request){

        if($request->ajax()){
            $patologias = $this->patologias($request);
            return view('dashboard.partials.reporte-patologia-anormal-table',compact('patologias'));
        }
        if($request->download){
            $patologias = $this->patologias($request);
            ExcelService::create(array_keys((array)collect($patologias)->first()),$patologias);
            exit;
        }
        return view('dashboard.patologia-anormal');
    }

    private function patologias(Request $request){
        if(!$request->fecha_resultado) $request->fecha_resultado="-hasta-";
        list($fecha_inicio,$fecha_fin) = explode('hasta',str_replace(" ","",$request->fecha_resultado));
        return  self::getPatologias((int)$request->numero_documento,$fecha_inicio,$fecha_fin);
    }

    public function reportePromedioAtencion(Request $request){
        if($request->ajax()){
            $promedios = $this->promediosAtencion($request);
            return view('dashboard.partials.reporte-promedio-atencion-table',compact('promedios'));
        }
        if($request->download){
            $promedios = $this->promediosAtencion($request);
            ExcelService::create(array_keys((array)collect($promedios)->first()),$promedios);
            exit;
        }
        return view('dashboard.tiempo-atencion');
    }

    private function promediosAtencion(Request $request){
        $numero_documente_paciente  = (int)$request->numero_documento_paciente;
        $numero_documente_medico = (int)$request->numero_documento_medico;
        list($fecha_inicio,$fecha_fin) = explode('hasta',str_replace(' ','',$request->fecha_registro));
        return $promedios = self::getSolicitudes($numero_documente_paciente,$numero_documente_medico,$fecha_inicio,$fecha_fin);
    }

    public function reporteProduccionMensual(Request $request){

    }



}
