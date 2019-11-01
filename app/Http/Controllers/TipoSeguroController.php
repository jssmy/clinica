<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoSeguro;
class TipoSeguroController extends Controller
{
    //

    public function index(Request $request){
        $tipoSeguros = TipoSeguro::with('usuario')->paginate(12);

        if($request->ajax()){
            return view('tipo-seguro.partials.tipo-seguro-table',compact('tipoSeguros'));
        }
        return view('tipo-seguro.index',compact('tipoSeguros'));
    }

    public function editarForm($tipo_id){
        $seguro = TipoSeguro::with('bitacora.usuario_accion')->find($tipo_id);
        return view('tipo-seguro.modals.editar-tipo-seguro',compact('seguro'));
    }

    public function editar(Request $request,$seguro_id){
        \DB::transaction(function () use ($request,$seguro_id){
            $seguro = TipoSeguro::find($seguro_id);
            $seguro->nombre = $request->nombre;
            $seguro->descripcion = $request->descripcion;
            $seguro->save();

            $seguro->bitacora()->create([
                'nombre'=>$seguro->nombre,
                'descripcion'=>$seguro->descripcion,
                'usuario_id'=>$seguro->usuario_id,
                'usuario_accion_id'=>auth()->id()
            ]);

        });

        return response()->json(['message'=>'Se ha actualizado correctamente']);
    }

    public function crearForm(){
        return view('tipo-seguro.modals.crear-tipo-seguro');
    }

    public function crear(Request $request){
        TipoSeguro::create([
            'nombre'=>$request->nombre,
            'descripcion'=>$request->descripcion,
            'usuario_id'=>auth()->user()->id
        ]);
        return response()->json(['message'=>'Se ha registrado el tipo de seguro']);
    }

    public function editarEstado($accion,$tipo_id){
        $seguro = TipoSeguro::find($tipo_id);
        if(strtolower($accion)=='activar') $seguro->estado=1;
        else $seguro->estado=0;
        $seguro->save();
        $message = strtolower($accion)=='activar' ? 'activado' : 'inactivado';
        return response()->json(['message'=>"El tipo de seguro fue $message."]);
    }
}
