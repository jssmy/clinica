<?php

namespace App\Http\Controllers;

use App\Models\ExamenCab;
use App\Models\ExamenDet;
use App\Models\Insumo;
use App\Models\UnidadMedida;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    //
    public function index(Request $request)
    {
        $insumos = Insumo::with('medida','usuario')->paginate(12);
        if($request->ajax()){
            return view('insumo.partials.insumo-table',compact('insumos'));
        }

        return view('insumo.index',compact('insumos'));
    }

    public function crearForm(){
        $unidades = UnidadMedida::activo()->get();
        $tipos_examen = ExamenDet::doesntHave('insumo')->activo()->get();
        return view('insumo.modals.crear-insumo',compact('unidades','tipos_examen'));
    }

    public function crear(Request $request){
        \DB::transaction(function () use ($request){
            $insumo =Insumo::create([
                'nombre'=>$request->nombre,
                'descripcion'=>$request->descripcion,
                'examen_det_id'=>$request->uso,
                'unidad_medida_id'=>$request->unidad_medida_id,
                'cantidad'=>$request->cantidad,
                'usuario_id'=>auth()->user()->id,
                'estado'=>1
            ]);
            $insumo->bitacora()->create([
                'nombre' =>$request->nombre,
                'descripcion'=> $request->descripcion,
                'uso' => $request->uso,
                'unidad_medida_id' => $request->unidad_medida_id,
                'cantidad' => $request->cantidad,
                'estado'=>$insumo->estado,
                'usuario_accion_id'=>auth()->user()->id,
                'examen_det_id'=>$request->uso,
                'estado'=>1
            ]);

        });
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
        $insumo = Insumo::with(['uso','bitacora.usuario_accion','bitacora.medida'])->find($insumo_id);
        $unidades = UnidadMedida::activo()->get();
        $tipos_examen = ExamenDet::doesntHave('insumo')->activo()->get();
        return view('insumo.modals.editar-insumo',compact('insumo','unidades','tipos_examen'));
    }

    public function editar(Request $request,$insumo_id){
        \DB::transaction(function () use ($request,$insumo_id){
            $insumo = Insumo::find($insumo_id);
            $insumo->nombre= $request->nombre;
            $insumo->descripcion = $request->descripcion;
            $insumo->unidad_medida_id = $request->unidad_medida_id;
            $insumo->cantidad = $request->cantidad;
            $insumo->examen_det_id = $request->uso;
            $insumo->save();


            $insumo->bitacora()->create([
                'nombre' =>$request->nombre,
                'descripcion'=> $request->descripcion,
                'unidad_medida_id' => $request->unidad_medida_id,
                'cantidad' => $request->cantidad,
                'estado'=>$insumo->estado,
                'examen_det_id'=>$request->uso,
                'usuario_accion_id'=>auth()->user()->id
            ]);
        });
        return response()->json(['message'=>'Se ha actualizado el insumo']);
    }

}
