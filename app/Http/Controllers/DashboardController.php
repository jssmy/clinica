<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\QueryPatologiaAnormal;
use App\Http\Controllers\Traits\QueryProduccionMensual;
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

    public function reportePacienteAtendido(){
        $persona = \request()->paciente;
        $analisis = RegistroAnalisis::where('paciente_id',\request()->paciente)
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

        return view('dashboard.partials.reporte-paciente-atendido',compact('persona','analisis','endDataPie','allAnalisis'));
    }


    public function profesionalMedico(){
        $colum = \request()->tecnologo ? 'usuario_resultado_id' :'empleado_id';
        $personas = (new Persona());
        if(\request()->tecnologo){
            $personas = $personas->join((new User())->getTable()." as usuario",'usuario.persona_id',Persona::getTableName().".id")
                        ->join(RegistroAnalisis::getTableName().' as analisis',"analisis.usuario_resultado_id",'usuario.id');
        }else{
            $personas=$personas->join(RegistroAnalisis::getTableName().' as analisis',"analisis.empleado_id",Persona::getTableName().'.id');
        }

        $personas = $personas->join(RestultadoAnalisis::getTableName().' as resultado','resultado.analisis_id','analisis.id')
                    ->selectRaw("genero,numero_documento,nombre,apellido_paterno,apellido_materno,resultado.id as examen");
        if(\request()->ajax() && !\request()->numero_documento && \request()->fecha_registro){

            list($fecha_inicio,$fecha_fin) = explode('/',str_replace([' ','hasta'],['','/'],\request()->fecha_registro));
            if(\request()->tecnologo){
                $personas = $personas->whereRaw('analisis.fecha_resultado >= ? and analisis.fecha_resultado <= ?',[$fecha_inicio,$fecha_fin]);
            }else {
                $personas = $personas->whereRaw('analisis.fecha_registro >= ? and analisis.fecha_registro <= ?',[$fecha_inicio,$fecha_fin]);
            }

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

        if(\request()->ajax()){

            return view('dashboard.partials.main-reporte-examen-medico',compact('endPersonas','endBarData'));
        }
        return view('dashboard.profesional-medico',compact('endPersonas','endBarData'));
    }

    public function reporteMedicoExamenesEmitidos(Request $request ,Persona $persona){
        $persona_id= $persona->id;
        $column=RegistroAnalisis::getTableName().".empleado_id";
        if($request->tecnologo){
            $analisis = $persona->analisisTecnologo;
            $persona_id = $persona->usuario->id;
            $column=RegistroAnalisis::getTableName().".usuario_resultado_id";
        }else {
            $analisis = $persona->analisis;
        }


        $resultados=RegistroAnalisis::join(RestultadoAnalisis::getTableName().' as resultado','resultado.analisis_id',RegistroAnalisis::getTableName().'.id')
            ->join(ExamenCab::getTableName().' as tipo_examen','tipo_examen.id','resultado.examen_cab_id')
            ->join(ExamenDet::getTableName().' as sub_tipo_examen','sub_tipo_examen.id','resultado.examen_det_id')
            ->whereRaw("$column=?",[$persona_id])
            ->selectRaw('tipo_examen.nombre as examen_tipo,sub_tipo_examen.nombre as examen_sub_tipo,count(1) as cantidad_sub_tipo')
            ->groupBy(['tipo_examen.nombre','sub_tipo_examen.nombre']);


        if($request->fecha_registro){
            list($fecha_inicio,$fecha_fin) = explode('/',str_replace([' ','hasta'],['','/'],\request()->fecha_registro));
            $resultados = $resultados->whereRaw('registro_analisis.fecha_registro>= ? and registro_analisis.fecha_registro <= ?',[$fecha_inicio,$fecha_fin]);
            $analisis = $analisis->where('fecha_registro','>=',$fecha_inicio)->where('fecha_registro','<=',$fecha_fin);
        }
        $resultados = $resultados->get();


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

        return view('dashboard.partials.reporte-medico-examen-emision',compact('persona','resultados','analisis','endPieData'));
    }

    public function reporteStockInsumo(Request $request){
        $semaforizacion = Semaforizacion::all();

        $insumos = Insumo::join(UnidadMedida::getTableName().' as medida','medida.id','unidad_medida_id')
                    ->leftJoin(ExamenDet::getTableName().' as sub_tipo_examen','sub_tipo_examen.id',Insumo::getTableName().'.examen_det_id')
                    ->selectRaw(Insumo::getTableName().".nombre AS insumo,".Insumo::getTableName().".cantidad,medida.nombre as unidad,sub_tipo_examen.nombre as uso");

        if($request->stock) $insumos = $insumos->where(Insumo::getTableName().".cantidad","<=",$request->stock);

        $insumos = $insumos->get();
        if($request->download){
            ExcelService::create(array_keys($insumos->first()->toArray()),$insumos->toArray());
            exit;
        }
        $insumos=$insumos->groupBy('insumo');
        $allInsumos = Insumo::activo()->get();
        $endBarData=[];
        foreach ($semaforizacion as $semaforo){
            $items = $allInsumos->where('cantidad','>=',$semaforo->rango_inicio)
                                ->where('cantidad','<=',$semaforo->rango_fin);
            $endBarData[]=['country'=>$semaforo->descripcion,'litres'=>$items->count(),'color'=>$semaforo->color];
        }

        return view('dashboard.stock-insumo',compact('insumos','endBarData','semaforizacion'));
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
        if(!$request->fecha_registro) $request->fecha_registro="0hasta0";
        list($fecha_inicio,$fecha_fin) = explode('hasta',str_replace(' ','',$request->fecha_registro));
        return $promedios = self::getSolicitudes($numero_documente_paciente,$numero_documente_medico,$fecha_inicio,$fecha_fin);
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
