<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\UnidadMedida;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    //
    public function index(Request $request)
    {
        $insumos = Insumo::with('medida')->paginate(12);
        if($request->ajax()){
            return view('insumo.partials.insumo-table',compact('insumos'));
        }
        $unidades = UnidadMedida::activo()->get();
        return view('insumo.index',compact('insumos','unidades'));
    }

    public function crearForm(){
        $unidades = UnidadMedida::activo()->get();
        return view('insumo.modals.crear-insumo',compact('unidades'));
    }

    public function crear(Request $request){
        Insumo::create([
            'nombre'=>$request->nombre,
            'descripcion'=>$request->descripcion,
            'uso'=>$request->uso,
            'unidad_medida_id'=>$request->unidad_medida_id,
            'cantidad'=>$request->cantidad,
            'usuario_id'=>2323,
        ]);
        return response()->json(['message'=>'Se ha creado el insumo']);
    }

    public function editarEstado($accion,$insumo_id){
        $insumo = Insumo::find($insumo_id);
        if(strtolower($accion)=='activar') $insumo->estado=1;
        else $insumo->estado=0;
        $insumo->save();
        $message = strtolower($accion)=='activar' ? 'activado' : 'inactivado';
        return response()->json(['message'=>"El tipo de seguro fue $message."]);
    }

    public function editarForm($insumo_id){
        $insumo = Insumo::find($insumo_id);
        $unidades = UnidadMedida::activo()->get();
        return view('insumo.modals.editar-insumo',compact('insumo','unidades'));
    }

    public function editar(Request $request,$insumo_id){
        $insumo = Insumo::find($insumo_id);
        $insumo->nombre= $request->nombre;
        $insumo->descripcion = $request->descripcion;
        $insumo->uso = $request->uso;
        $insumo->unidad_medida_id = $request->unidad_medida_id;
        $insumo->cantidad = $request->canitida;
        $insumo->save();

        $insumo->bitacora()->create([
            'nombre' =>$request->nombre,
            'descripcion'=> $request->descripcion,
            'uso' => $request->uso,
            'unidad_medida_id' => $request->unidad_medida_id,
            'cantidad' => $request->cantidad,
            'estado'=>$insumo->estado,
            'usuario_id'=>$insumo->usuario_id,
            'fecha_registro'=>$insumo->fecha_creacion,
            'usuario_accion_id'=>213232
        ]);
        return response()->json(['message'=>'Se ha actualizado el insumo']);
    }

}
