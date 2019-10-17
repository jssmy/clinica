<?php

namespace App\Http\Controllers;

use App\Models\ExamenCab;
use Illuminate\Http\Request;

class ExamenCabController extends Controller
{
    //

    public function index(Request $request){
        $examenes = ExamenCab::paginate(12);
        if($request->ajax()){
            return view('examen-cab.partials.examen-cab-table',compact('examenes'));
        }
        return view('examen-cab.index',compact('examenes'));
    }

    public function crearForm(){
        return view('examen-cab.modals.crear-examen-cab');
    }

    public function crear(Request $request){
        ExamenCab::create([
            'nombre'=>$request->nombre,
            'descripcion'=>$request->descripcion,
            'usuario_id'=>123123
        ]);
        return response()->json(['message'=>'Se ha creado el examen cab']);
    }

    public function editarEstado($accion,$examen_id){
        $examen = ExamenCab::find($examen_id);
        if(strtolower($accion)=='activar') $examen->estado=1;
        else $examen->estado=0;
        $examen->save();
        $message = strtolower($accion)=='activar' ? 'activado' : 'inactivado';
        return response()->json(['message'=>"El examen cab fue $message."]);
    }

    public function editarForm($examen_id){
        $examen = ExamenCab::find($examen_id);
        return view('examen-cab.modals.editar-examen-cab',compact('examen'));
    }

    public function editar(Request $request,ExamenCab $examenCab){
        $examenCab->nombre = $request->nombre;
        $examenCab->descripcion = $request->descripcion;
        $examenCab->save();
        return response()->json(['message'=>'Se ha actualizado el examen cab']);
    }
}
