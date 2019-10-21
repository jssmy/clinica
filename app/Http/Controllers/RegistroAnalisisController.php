<?php

namespace App\Http\Controllers;

use App\Http\Requests\CambiarAnalisisRequest;
use App\Models\AnalisisTipoExamen;
use App\Models\EstadoCivil;
use App\Models\ExamenCab;
use App\Models\ExamenDet;
use App\Models\Insumo;
use App\Models\Persona;
use App\Models\RegistroAnalisis;
use App\Models\RestultadoAnalisis;
use Illuminate\Http\Request;

class RegistroAnalisisController extends Controller
{
    //

    public function index(Request $request){

        return view('registro-analisis.index',compact('registros','tiposExamen'));
    }

    public function crearForm(Persona $persona){
        $tiposExamen  = ExamenCab::activo()->get();
        return view('registro-analisis.modals.crear-registro-analisis',compact('tiposExamen','persona'));
    }

    public function encontrarPersona($tipo,$numero_documento){
        $persona=null;
        if($tipo=='paciente'){
            $persona = Persona::with('paciente')
                ->soloPaciente()
                ->where('numero_documento',$numero_documento)
                ->first();
            if(!$persona){
                return response('elemento no encotrado',422);
            }

            //return view('registro-analisis.modals.partials.registro-persona',compact('persona'));
        }else if($tipo='medico'){
            $persona = Persona::where('numero_documento',$numero_documento)->soloMedico()->first();

            if(!$persona){
                return response('elemento no encotrado',422);
            }
            //return view('registro-analisis.modals.partials.registro-medico',compact('persona'));

        }
        return view('persona.partials.datos-personales',compact('persona'));
    }

    public function crear(Request $request){

        \DB::transaction(function () use ($request){
            $analisis=RegistroAnalisis::create([
                /* crear registro de analisis */
                'paciente_id'=>$request->paciente_id,
                'empleado_id'=>$request->medico_id,
                'usuario_id'=>auth()->user()->id,
                'codigo'=>RegistroAnalisis::generarCodigo(),
            ]);
            /*crear analisis + tipos de examne */
            $tipos_examen = $request->tipos_examen;
            foreach ($tipos_examen  as $examen_cab_id => $exmanen_det_id){
                AnalisisTipoExamen::create([
                    'usuario_id'    => auth()->user()->id,
                    'analisis_id'   => $analisis->id,
                    'examen_cab_id' => $examen_cab_id,
                    'examen_det_id' => $exmanen_det_id,
                ]);
                $insumo = ExamenDet::find($exmanen_det_id)->insumo()->first();
                $insumo->cantidad = (int)$insumo->cantidad - 1;
                $insumo->save();
            }
        });



        return response()->json(['message'=>'Se ha registrado correctamente el análisis']);
    }


    public function analisisTable(Request $request,$persona_id){
        $registros = RegistroAnalisis::where('paciente_id',$persona_id)->paginate(8);
        return view('registro-analisis.partials.registro-table',compact('registros'));
    }

    public function resultadosAnalisis($analisis_id){
        //dd($analisis_id);
        $resultados = RestultadoAnalisis::with('tipoExamen','subTipoExamen')
                        ->where('analisis_id',$analisis_id)
                        ->get();
        //dd($resultados,$analisis_id);
        return view('registro-analisis.modals.resultados-analisis',compact('resultados'));
    }

    public function cambiarPacienteForm(RegistroAnalisis $analisis){
        $analisis = $analisis->load('medico');
        return view('registro-analisis.partials.cambiar-paciente',compact('analisis'));
    }

    public function cambiarPacienteStore(CambiarAnalisisRequest $request,RegistroAnalisis $analisis){
        $analisis->paciente_id = $request->paciente_id;
        $analisis->save();
        return response()->json(['message'=>'El análisis fue movido a otro paciente']);
    }
}
