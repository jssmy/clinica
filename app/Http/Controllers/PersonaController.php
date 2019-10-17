<?php

namespace App\Http\Controllers;

use App\Models\EstadoCivil;
use App\Models\Persona;
use App\Models\TipoSeguro;
use Illuminate\Auth\DatabaseUserProvider;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    //
    public function index(Request $request){
        $personas = Persona::paginate(12);
        if($request->ajax()){
            return view('persona.partials.persona-table',compact('personas'));
        }
        $estados = EstadoCivil::activo()->get();
        $tipo_seguros=TipoSeguro::activo()->get();

        return view('persona.index',compact('personas','estados','tipo_seguros'));
    }
    public function crearForm(){
        $estados = EstadoCivil::activo()->get();
        $tipo_seguros=TipoSeguro::activo()->get();
        return view('persona.modals.crear-persona',compact('estados','tipo_seguros'));
    }
    public function crear(Request $request){
        $persona=Persona::create([
            'nombre'=>$request->nombre,
            'apellido_paterno'=>$request->apellido_materno,
            'numero_documento'=>$request->numero_documento,
            'direccion'=>$request->direccion,
            'telefono'=>$request->telefono,
            'fecha_nacimiento'=>now(),
            'genero'=>$request->genero,
            'estado_civil_id'=>$request->estado_civil,
            'tipo_persona'=>strtolower($request->tipo_persona),
            'usuario_id'=>121212
        ]);

        if(strtolower($request->tipo_persona)=='empleado'){
            $persona->empleado()->create([
                'numero_colegiatura'=>$request->numero_colegiatura,
                'usuario_id'=>232323
            ]);
        }else if(strtolower($request->tipo_persona)=='paciente'){
            $persona->paciente()->create([
                'tipo_seguro_id'=>$request->tipo_seguro,
                'numero_historia_clinica'=>$request->numero_historia,
                'usuario_id'=>121212
            ]);
        }
        return response()->json(['message'=>'La persona fue creado']);

    }

    public function editarForm (Persona $persona){
        $persona = $persona->load($persona->es_paciente ? 'paciente' : 'empleado');

        $estados = EstadoCivil::activo()->get();
        $tipo_seguros  = TipoSeguro::activo()->get();
        return view('persona.modals.editar-persona',compact('persona','estados','tipo_seguros'));
    }
    public function editar(Request $request,Persona $persona){
        $persona = $persona->load($persona->es_paciente ? 'paciente' : 'empleado');
        $persona->numero_documento = $request->numero_documento;
        $persona->telefono = $request->telefono;
        $persona->nombre = $request->nombre;
        $persona->apellido_paterno   = $request->apellido_paterno;
        $persona->apellido_materno   = $request->apellido_materno;
        $persona->direccion = $request->direccion;
        $persona->genero = $request->genero;
        $persona->estado_civil_id = $request->estado_civil;
        $persona->save();
        if($persona->es_paciente){
                if(!$persona->paciente){
                    /**crear */
                    $persona->paciente()->create([
                        'tipo_seguro_id'=>$request->tipo_seguro,
                        'numero_historia_clinica'=>$request->numero_historia,
                        'usuario_id'=>1121221
                    ]);
                }else {
                    /** deitar */
                    $persona->paciente()->update([
                        'tipo_seguro_id'=>$request->tipo_seguro,
                        'numero_historia_clinica'=>$request->numero_historia
                    ]);
                }
        }else if(!$persona->es_paciente){
                if(!$persona->empleado){
                    $persona->empleado()->create([
                        'numero_colegiatura'=>$request->numero_colegiatura,
                        'usuario_id'=>121212
                    ]);
                }else{
                    $persona->empleado()->update([
                        'numero_colegiatura'=>$request->numero_colegiatura,
                    ]);
                }
        }

        return response()->json(['message'=>'Se ha actualizado los datos de la persona']);
    }
}
