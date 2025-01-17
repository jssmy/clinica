<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class PerfilController extends Controller
{
    //

    public function index(Request $request){
        $perfiles = Perfil::with('usuario')->paginate(15);
        if($request->ajax()){
            return view('perfil.partials.perfil-table',compact('perfiles'));
        }
        return view('perfil.index',compact('perfiles'));
    }

    public function crearForm(){
        return view('perfil.modals.crear-perfil');
    }

    public function crear(Request $request){

        \DB::transaction(function () use ($request){
            $perfil = Perfil::create([
                'id'=>$request->perfil,
                'descripcion'=>$request->descripcion,
                'usuario_id'=>auth()->user()->id
            ]);
            $perfil->bitacora()->create([
                'id'=>$request->perfil,
                'descripcion'=>$request->descripcion,
                'estado'=>1,
                'usuario_accion_id'=>auth()->id()
            ]);
        });

        return response()->json(['message'=>'Se ha registrado el perfil']);
    }

    public function editarEstado($accion, $perfil_id){


        $perfil = Perfil::find($perfil_id);
        if(strtolower($accion)=='activar') $perfil->estado=1;
        else $perfil->estado=0;
        $perfil->save();
        $message = strtolower($accion)=='activar' ? 'activado' : 'inactivado';
        return response()->json(['message'=>"El perfil fue $message."]);
    }

    public function editarForm($perfil_id){
        $perfil = Perfil::with('bitacora.usuario_accion')->find($perfil_id);
        return view('perfil.modals.editar-perfil',compact('perfil'));
    }

    public function editar(Request $request,$perfil_id){
        \DB::transaction(function () use ($request,$perfil_id){
            $perfil = Perfil::find($perfil_id);
            $perfil->id=$request->perfil;
            $perfil->descripcion = $request->descripcion;
            $perfil->save();
            $perfil->bitacora()->create([
                'descripcion'=>$request->descripcion,
                'estado'=>$perfil->estado,
                'usuario_accion_id'=>auth()->id()
            ]);
        });
        return response()->json(['message'=>'Se ha actualizado el perfil']);
    }
}
