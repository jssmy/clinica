<?php

namespace App\Http\Controllers;

use App\Models\EstadoCivil;
use App\Models\ExamenCab;
use App\Models\Persona;
use App\Models\RegistroAnalisis;
use Illuminate\Http\Request;

class RegistroAnalisisController extends Controller
{
    //

    public function index(){
        $registros = RegistroAnalisis::paginate(15);
        $tiposExamen = ExamenCab::activo()->get();

        return view('registro-analisis.index',compact('registros','tiposExamen'));
    }

    public function crearForm(){

        return view('registro-analisis.modals.crear-registro-analisis');
    }

    public function encontrarPersona($tipo,$numero_documento){
        if($tipo=='paciente'){
            $persona = Persona::with('paciente')
                ->soloPaciente()
                ->where('numero_documento',$numero_documento)
                ->first();
            if(!$persona){
                return response('elemento no encotrado',422);
            }

            return view('registro-analisis.modals.partials.registro-persona',compact('persona'));
        }else if($tipo='medico'){
            $persona = Persona::where('numero_documento',$numero_documento)->soloMedico()->first();

            if(!$persona){
                return response('elemento no encotrado',422);
            }
            return view('registro-analisis.modals.partials.registro-medico',compact('persona'));

        }

    }
}
