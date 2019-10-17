<?php

namespace App\Http\Controllers;

use App\Models\EstadoCivil;
use Illuminate\Http\Request;

class EstadoCivilController extends Controller
{
    //

    public function index(Request $request){
        $estados = EstadoCivil::paginate(12);
        if($request->ajax()){
            return view('estado-civil.partials.estado-civil-table',compact('estados'));
        }
        return view('estado-civil.index',compact('estados'));
    }

    public function crearForm(){
        return view('estado-civil.modals.crear-estado-civil');
    }

    public function crear(Request $request){
        EstadoCivil::create([
            'nombre'=>$request->nombre,
            'usuario_id'=>122233
        ]);
        return response()->json(['message'=>'Se ha registrado el estado civil']);
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
        return response()->json(['Se ha actualizado el perfil']);
    }

}
