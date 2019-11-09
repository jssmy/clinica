<?php

namespace App\Http\Controllers;

use App\Models\ExamenCab;
use App\Models\ExamenDet;
use App\Models\Insumo;
use Illuminate\Http\Request;

class ExamenDetController extends Controller
{
    //
    public function index(Request $request){
        $examenes = ExamenDet::with(['usuario','tipo_examen'=>function($query){
                    $query->orderBy('nombre');
                    }])
                    ->paginate(12);

        $tipo_examenes = ExamenCab::activo()->get();
        if($request->ajax()){
            return view('examen-det.partials.examen-det-table',compact('examenes'));
        }
        return view('examen-det.index',compact('examenes','tipo_examenes'));
    }

    public function crearForm(){
        $tipo_examenes = ExamenCab::activo()->get();
        return view('examen-det.modals.crear-examen-det',compact('tipo_examenes'));
    }
    public function crear(Request $request){
        \DB::transaction(function () use ($request){
            $examen =ExamenDet::create([
                'nombre'=>$request->nombre,
                'descripcion'=>$request->descripcion,
                'examen_cab_id'=>$request->tipo_examen,
                'usuario_id'=>auth()->user()->id
            ]);
            $examen->bitacora()->create([
                'nombre'=>$request->nombre,
                'descripcion'=>$request->descripcion,
                'examen_cab_id'=>$request->tipo_examen,
                'estado'=>1,
                'usuario_accion_id'=>auth()->id()
            ]);
        });

        return response()->json(['message'=>"Se ha registrado el sub-tipo de examen"]);
    }

    public function editarEstado($accion,$examen_id){
        if(strtolower($accion)=='activar') ExamenDet::where('id',$examen_id)->update(['estado'=>1]);
        else ExamenDet::where('id',$examen_id)->update(['estado'=>0]);
        $msg = strtolower($accion)=="activar" ? "activado" : "inactivado";
        return response()->json(['message'=>"El sub-tipo de examen fue $msg"]);
    }

    public function editarForm($examen_id){
        $examen=ExamenDet::with('bitacora.usuario_accion')->find($examen_id);
        $tipo_examenes = ExamenCab::activo()->get();
        return view('examen-det.modals.editar-examen-det',compact('tipo_examenes','examen'));
    }

    public function editar(Request $request,ExamenDet $examenDet){
        \DB::transaction(function () use (&$examenDet,$request){
            $examenDet->nombre = $request->nombre;
            $examenDet->descripcion = $request->descripcion;
            $examenDet->examen_cab_id = $request->tipo_examen;
            $examenDet->save();
            $examenDet->bitacora()->create([
                'nombre'=>$request->nombre,
                'descripcion'=>$request->descripcion,
                'examen_cab_id'=>$request->tipo_examen,
                'estado'=>1,
                'usuario_accion_id'=>auth()->id()
            ]);
        });

        return response()->json(['message'=>'El sub-tipo de examen fue actualizado']);
    }
}
