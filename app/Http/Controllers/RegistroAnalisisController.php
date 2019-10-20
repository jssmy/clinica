<?php

namespace App\Http\Controllers;

use App\Models\AnalisisTipoExamen;
use App\Models\EstadoCivil;
use App\Models\ExamenCab;
use App\Models\Persona;
use App\Models\RegistroAnalisis;
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
                'usuario_id'=>auth()->user()->id
            ]);
            /*crear analisis + tipos de examne */
            $tipos_examen = $request->tipos_examen;
            foreach ($tipos_examen  as $examen_cab_id => $tipo){
                foreach ($tipo as $exment_det_id){
                    AnalisisTipoExamen::create([
                        'usuario_id'=>auth()->user()->id,
                        'analisis_id'=>$analisis->id,
                        'examen_cab_id'=>$examen_cab_id,
                        'examen_dex_id'=>$exment_det_id
                    ]);
                }
            }


        });



        return response()->json(['message'=>'Se ha registrado correctamente el análisis']);
    }


    public function analisisTable(Request $request,$persona_id){
        $registros = RegistroAnalisis::where('paciente_id',$persona_id)->paginate(8);
        return view('registro-analisis.partials.registro-table',compact('registros'));
    }


}
