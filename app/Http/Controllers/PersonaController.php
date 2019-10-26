<?php

namespace App\Http\Controllers;

use App\Models\EstadoCivil;
use App\Models\Persona;
use App\Models\TipoSeguro;
use Illuminate\Auth\DatabaseUserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function foo\func;

class PersonaController extends Controller
{
    //
    public function index(Request $request,$tipo_persona){

        if(!in_array($tipo_persona,['paciente','medico'])){
            abort(404,'No encontrado');
        }
        $personas = Persona::with('estadoCivil','usuario')->paginate(12);
        if($request->ajax()){
            return view('persona.partials.persona-table',compact('personas','tipo_persona'));
        }

        $estados = EstadoCivil::activo()->get();
        $tipo_seguros=TipoSeguro::activo()->get();

        return view('persona.index',compact('personas','estados','tipo_seguros','tipo_persona'));
    }
    public function crearForm($tipo_persona){
        $estados = EstadoCivil::activo()->get();
        $tipo_seguros=TipoSeguro::activo()->get();
        return view('persona.modals.crear-persona',compact('estados','tipo_seguros','tipo_persona'));
    }
    public function crear(Request $request){
        //dd($request->all());
        \DB::transaction(function () use ($request){
            $persona=Persona::create([
                'nombre'=>$request->nombre,
                'apellido_paterno'=>$request->apellido_paterno,
                'apellido_materno'=>$request->apellido_materno,
                'numero_documento'=>$request->numero_documento,
                'direccion'=>$request->direccion,
                'telefono'=>$request->telefono,
                'fecha_nacimiento'=>date("Y-m-d"),
                'genero'=>$request->genero,
                'estado_civil_id'=>$request->estado_civil,
                'tipo_persona'=>strtolower($request->tipo_persona)=='medico' ? 'empleado' : 'paciente',
                'usuario_id'=>auth()->user()->id
            ]);

            if(in_array(strtolower($request->tipo_persona),['medico','empleado'])){
                $persona->empleado()->create([
                    'numero_colegiatura'=>$request->numero_colegiatura,
                    'usuario_id'=>auth()->user()->id
                ]);
            }else if(strtolower($request->tipo_persona)=='paciente'){
                $persona->paciente()->create([
                    'tipo_seguro_id'=>$request->tipo_seguro,
                    'numero_historia_clinica'=>$request->numero_historia,
                    'usuario_id'=>auth()->user()->id
                ]);
            }

        });
        return response()->json(['message'=>'La persona fue creado']);

    }

    public function editarForm ($tipo_persona,Persona $persona){
        $persona = $persona->load($persona->es_paciente ? 'paciente' : 'empleado');
        $estados = EstadoCivil::activo()->get();
        $tipo_seguros  = TipoSeguro::activo()->get();
        return view('persona.modals.editar-persona',compact('persona','estados','tipo_seguros','tipo_persona'));
    }
    public function editar(Request $request,Persona $persona){
        \DB::transaction(function () use ($request,&$persona){
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
                        'usuario_id'=>auth()->user()->id
                    ]);
                }else {
                    /** deitar */
                    $persona->paciente()->update([
                        'tipo_seguro_id'=>$request->tipo_seguro,
                        'numero_historia_clinica'=>$request->numero_historia
                    ]);
                }
            }else if(!$persona->es_paciente){
                $empleado = $persona->empleado;

                if(!$persona->empleado){
                    $persona->empleado()->create([
                        'numero_colegiatura'=>$request->numero_colegiatura,
                        'usuario_id'=>auth()->user()->id
                    ]);
                }else{
                    $persona->empleado()->update([
                        'numero_colegiatura'=>$request->numero_colegiatura,
                    ]);
                }
            }
        });
        return response()->json(['message'=>'Se ha actualizado los datos de la persona']);
    }

    public function datosPersonales (Request $request,$tipo_persona,$tipo_busqueda='numero_documento'){
        $tipo_persona = $tipo_persona == 'medico' ? 'empleado' : 'paciente';
        $persona=Persona::where('numero_documento',$request->numero_documento)
                        ->where('tipo_persona',$tipo_persona)
                        ->first();

        return view('layouts.main.load-sections',compact('persona','tipo_persona'));
    }
}
