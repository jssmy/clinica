<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\QueryExamenEmision;
use App\Http\Controllers\Traits\QueryPacienteAtendido;
use App\Http\Controllers\Traits\QueryPatologiaAnormal;
use App\Http\Controllers\Traits\QueryProduccionMensual;
use App\Http\Controllers\Traits\QueryProfesionalMedico;
use App\Http\Controllers\Traits\QueryStockInsumo;
use App\Http\Controllers\Traits\QueryTiemPromedioAtencion;
use App\Models\Entity;
use App\Models\ExamenCab;
use App\Models\ExamenDet;
use App\Models\Insumo;
use App\Models\Perfil;
use App\Models\Persona;
use App\Models\RegistroAnalisis;
use App\Models\RestultadoAnalisis;
use App\Models\Semaforizacion;
use App\Models\UnidadMedida;
use App\Services\ExcelService;
use App\User;

use Faker\Provider\Person;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    use QueryPatologiaAnormal;
    use QueryTiemPromedioAtencion;
    use QueryProduccionMensual;
    use QueryPacienteAtendido;
    use QueryProfesionalMedico;
    use QueryExamenEmision;
    use QueryStockInsumo;
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
                return ;
            case  'medico-examen-emision':
                return "";
            case  'stock-insuno':
                return $this->reporteStockInsumo();

        }
    }

    public function pacienteAtendido(Persona $persona){
        if(\request()->ajax()){
            return $this->reportePacienteAtendido();
        }
        return view('dashboard.paciente-atendido');
    }

    public static function downloadReportePacienteAtendido($paciente_id){
            $analisis = self::getAtencion($paciente_id);
            $header = ['ID','TIPO DE EXAMEN','SUB-TIPO DE EXAMEN','FECHA DE RESULTADO','RESULTADO','ESTADO'];
            $title=["REPORTE DE PACIENTE ATENDIDO","PACIENTE: ".Persona::find($paciente_id)->nombre_completo];
            ExcelService::create($title,$header,$analisis->flatten()->toArray());
            exit;
    }


    public function reportePacienteAtendido(){
        $persona = \request()->paciente;
        $analisis = self::getAtencion(\request()->paciente);

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



    public function downloadPrefesionalMedico(Persona $persona){

            $resultados = self::getEmision($persona);
            $header = ["TIPO DE EXAMEN","SUB-TIPO DE EXAMEN","CANTIDAD"];
            $title=[!\request()->tecnologo ? "REPORTE DE PROFESIONAL MÉDICO" : "REPORTE DE PROFESIONAL DE LABORATORIO","MÉDICO: ".$persona->nombre_completo];
            if(\request()->fecha_registro){
                list($fecha_inicio,$fecha_fin) = explode('/',str_replace([' ','hasta'],['','/'],\request()->fecha_registro));
                $fecha_inicio = str_replace("-","/",$fecha_inicio);
                $fecha_fin = str_replace("-","/",$fecha_fin);
                array_push($title,"FECHA DESDE -HASTA: $fecha_inicio - $fecha_fin");
            }
            ExcelService::create($title,$header,$resultados->toArray());
            exit;
    }

    public function profesionalMedico(){

        $personas = self::getProfesional();
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
        if(\request()->ajax()){

            return view('dashboard.partials.main-reporte-examen-medico',compact('endPersonas','endBarData'));
        }
        return view('dashboard.profesional-medico',compact('endPersonas','endBarData'));
    }

    public function reporteMedicoExamenesEmitidos(Request $request ,Persona $persona){

        $resultados = self::getEmision($persona);
        $analisis = self::getAnalisis($persona);

            $resultados =$resultados->groupBy('examen_tipo');
            $piedaData = $resultados->flatten();
            $endPieData=[];
            foreach ($piedaData as $data){
                $endPieData[]=['country'=>(string)$data->examen_sub_tipo,'litres'=>$data->cantidad_sub_tipo];
            }

        return view('dashboard.partials.reporte-medico-examen-emision',compact('persona','resultados','analisis','endPieData'));
    }
    public function donwloadStockInsumo(Request $request){
        $insumos = self::getStock($request);
        $header=["INSUMO",'CANTIDAD','UNIDAD','USO'];
        $title=["REPORTE DE STOCK DE INSUMOS"];
        if($request->stock>0){
            array_push($title,"STOCK: ".$request->stock);
        }
        ExcelService::create($title,$header,$insumos->toArray());

    }
    public function reporteStockInsumo(Request $request){
        $semaforizacion = Semaforizacion::all();
        $insumos = self::getStock($request);

        $insumos=$insumos->groupBy('insumo');

        $allInsumos = $insumos->flatten();
        $endBarData=[];
        foreach ($semaforizacion as $semaforo){
            $items = $allInsumos->where('cantidad','>=',$semaforo->rango_inicio)
                                ->where('cantidad','<=',$semaforo->rango_fin);
            $endBarData[]=['country'=>$semaforo->descripcion,'litres'=>$items->count(),'color'=>$semaforo->color];
        }

        return view('dashboard.stock-insumo',compact('insumos','endBarData','semaforizacion'));
    }

    public function reportePatologiaAnormal(Request $request){

        $fecha_fin=0;
        $fecha_inicio=0;
        if(!$request->fecha_resultado) {
            $request->fecha_resultado="-hasta-";
            list($fecha_inicio,$fecha_fin) = explode('hasta',str_replace(" ","",$request->fecha_resultado));
        }

        $patologias=  self::getPatologias((int)$request->numero_documento,$fecha_inicio,$fecha_fin);

        if($request->ajax()){
            return view('dashboard.partials.reporte-patologia-anormal-table',compact('patologias'));
        }

        return view('dashboard.patologia-anormal',compact('patologias'));
    }

    public function downloadPatologiaAnormal(Request $request){
        $fecha_fin=0;
        $fecha_inicio=0;
        if($request->fecha_resultado) {
            list($fecha_inicio,$fecha_fin) = explode('hasta',str_replace(" ","",$request->fecha_resultado));
        }

        $patologias=  self::getPatologias((int)$request->numero_documento,$fecha_inicio,$fecha_fin);
        $header=["CÓDIGO",'PACIENTE','TIPO DE EXAMEN','SUB-TIPO DE EXAMEN','RESULTADO','OBSERVACIÓN'];
        $title=["REPORTE DE PATOLOGÍAS ANORMALES"];
        if($request->numero_documento){
            $paciente = Persona::SoloPaciente()->where('numero_documento',$request->numero_documento)->first();
            array_push($title,"PACIENTE: ".($paciente ? $paciente->nombre_completo : null));
        }

        if($fecha_inicio && $fecha_fin){
            array_push($title,"FECHA DESDE -HASTA: $fecha_inicio - $fecha_fin");
        }
        ExcelService::create($title,$header,$patologias->toArray());
        exit;



    }



    public function downloadPromedioAtencion(Request $request){
            $promedios = $this->promediosAtencion($request);

            $title=["REPORTE DE TIEMPO PROMEDIO DE ATENCIÓN"];
            if($request->numero_documento_paciente){
                    $paciente = Persona::SoloPaciente()->where('numero_documento',$request->numero_documento_paciente)->first();
                    array_push($title,"PACIENTE: ".$paciente->nombre_completo);
            }
            if($request->numero_documento_medico){
                $medico = Persona::SoloMedico()->where('numero_documento',$request->numero_documento_medico)->first();
                array_push($title,"MÉDICO: ".$medico->nombre_completo);
            }
            if($request->fecha_registro){
                list($fecha_inicio,$fecha_fin) = explode('hasta',str_replace(' ','',$request->fecha_registro));
                $fecha_inicio = str_replace("-","/",$fecha_inicio);
                $fecha_fin = str_replace("-","/",$fecha_fin);
                array_push($title,"FECHA DESDE -  HASTA: $fecha_inicio - $fecha_fin");
            }
        $header=["CÓDIGO","TIPO DE EXAMEN","SUB TIPO DE EXAMEN","FECHA DE REGISTRO","FECHA DE RESULTADO","DIFERENCIA (min)"];

            ExcelService::create($title,$header,$promedios->toArray());
            exit;
    }
    public function reportePromedioAtencion(Request $request){
        $promedios = $this->promediosAtencion($request);
        if($request->ajax()){
            return view('dashboard.partials.reporte-promedio-atencion-table',compact('promedios'));
        }

        return view('dashboard.tiempo-atencion',compact('promedios'));
    }

    private function promediosAtencion(Request $request){
        $numero_documente_paciente  = (int)$request->numero_documento_paciente;
        $numero_documente_medico = (int)$request->numero_documento_medico;
        $fecha_registro = $request->fecha_registro;
        if(!$fecha_registro) $fecha_registro="0hasta0";
        list($fecha_inicio,$fecha_fin) = explode('hasta',str_replace(' ','',$fecha_registro));
        return $promedios = self::getSolicitudes($numero_documente_paciente,$numero_documente_medico,$fecha_inicio,$fecha_fin);
    }

    public function downloadProduccionMensual(Request $request){
        $produccion = self::getProduccion($request->tipo_examen);
        $title=["REPORTE DE PRODUCCIÓN MENSUAL"];
        if($request->tipo_examen){
            $tipo_examen = ExamenCab::find($request->tipo_examen);
            array_push($title,"TIPO DE EXAMEN: ".$tipo_examen->nombre);
        }

        $header=["MES","TIPO DE EXAMEN","SUB-TIPO DE EXAMEN","PAGANTES","SIS"];

        ExcelService::create($title,$header,$produccion->toArray());
        exit;
    }

    public function produccionMensual(Request $request){
        $examenes = ExamenCab::activo()->get();
        $produccion = self::getProduccion($request->tipo_examen);
        if($request->ajax()){
            return view('dashboard.partials.reporte-produccion-mensual',compact('produccion'));
        }
        return view('dashboard.produccion-mensual',compact('examenes','produccion'));
    }





}
