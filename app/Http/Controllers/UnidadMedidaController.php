<?php

namespace App\Http\Controllers;

use App\Models\UnidadMedida;
use Illuminate\Http\Request;

class UnidadMedidaController extends Controller
{
    //
    public function index(Request $request){

        $unidades=UnidadMedida::with('usuario')->paginate(12);
        if($request->ajax()){
            return view('unidad-medida.partials.unidad-medida-table',compact('unidades'));
        }
        return view('unidad-medida.index',compact('unidades'));
    }

    public function crearForm(){
        return view('unidad-medida.modals.crear-unidad-medida');
    }

    public function crear(Request $request){
        \DB::transaction(function () use($request){
            $unidad =UnidadMedida::create([
                'nombre'=>$request->nombre,
                'descripcion'=>$request->descripcion,
                'usuario_id'=>auth()->user()->id
            ]);
            $unidad->bitacora()->create([
                'nombre'=>$request->nombre,
                'descripcion'=>$request->descripcion,
                'estado'=>1,
                'usuario_accion_id'=>auth()->user()->id
            ]);
        });

        return response()->json(['message'=>'Se ha registrado la unidad de medida']);
    }

    public function editarForm($unidad_id){
        $unidad = UnidadMedida::with('bitacora.usuario_accion')->find($unidad_id);

        return view('unidad-medida.modals.editar-unidad-medida',compact('unidad'));
    }

    public function editar(Request $request,$unidad_id){
        \DB::transaction(function () use($request,$unidad_id){
            $unidad = UnidadMedida::find($unidad_id);
            $unidad->nombre = $request->nombre;
            $unidad->descripcion = $request->descripcion;
            $unidad->save();
            $unidad->bitacora()->create([
                'nombre'=>$request->nombre,
                'descripcion'=>$request->descripcion,
                'estado'=>$unidad->estado,
                'estado'=>$unidad->estado,
                'usuario_accion_id'=>auth()->user()->id
            ]);
        });
        return response()->json(['message'=>'Se ha actualizado correctamente']);
    }

    public function editarEstado($accion,$unida_id){
        $unidad = UnidadMedida::find($unida_id);
        if(strtolower($accion)=='activar') $unidad->estado=1;
        else $unidad->estado=0;
        $unidad->save();
        $message = strtolower($accion)=='activar' ? 'activado' : 'inactivado';
        return response()->json(['message'=>"El tipo de seguro fue $message."]);
    }

}
