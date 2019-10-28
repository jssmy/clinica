<?php

namespace App\Http\Controllers;

use App\Models\EstadoCivil;
use App\Models\Perfil;
use App\Models\Persona;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    //

    public function index(Request $request){
        $perfiles = Perfil::activo()->get();
        return view('usuario.index',compact('perfiles'));
    }

    public function crearForm(){

        return view('estado-civil.modals.crear-estado-civil');
    }

    public function crear(Request $request,Persona $persona){

        $persona->usuario()->create([
            'usuario'=>$request->usuario,
            'contrasena'=>md5($request->contrasena),
            'usuario_id'=>auth()->id()
        ]);
        return response()->json(['message'=>'Se ha registrado el usuario']);
    }

    public function editarEstado($accion,$estado_id){
        $estado = EstadoCivil::find($estado_id);
        if(strtolower($accion)=='activar') $estado->estado=1;
        else $estado->estado=0;
        $estado->save();
        $message = strtolower($accion)=='activar' ? 'activado' : 'inactivado';
        return response()->json(['message'=>"El tipo de seguro fue $message."]);
    }

    public function editarForm($estado_id){
        $estado = EstadoCivil::find($estado_id);
        return view('estado-civil.modals.editar-estado-civil',compact('estado'));
    }

    public function editar(Request $request,$estado_id){
        $estado = EstadoCivil::find($estado_id);
        $estado->nombre = $request->nombre;
        $estado->save();
        return response()->json(['message'=>'Se ha actualizado el perfil']);
    }

}
