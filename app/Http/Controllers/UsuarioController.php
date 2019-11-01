<?php

namespace App\Http\Controllers;

use App\Models\EstadoCivil;
use App\Models\Perfil;
use App\Models\Persona;
use App\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    //

    public function index(Request $request){
        $usuarios = User::with(['persona','perfil']);
        if($request->ajax()){
            if($request->numero_documento){
                $usuarios = $usuarios->whereHas('persona',function ($query) use ($request){
                    $query->where('numero_documento',$request->numero_documento);
                });
            }
            $usuarios = $usuarios->paginate(12);
            return view('usuario.partials.usuario-table',compact('usuarios'));
        }
        $usuarios = $usuarios->paginate(12);
        $perfiles = Perfil::activo()->get();
        return view('usuario.index',compact('perfiles','usuarios'));
    }

    public function crearForm(){

        return view('estado-civil.modals.crear-estado-civil');
    }

    public function crear(Request $request,Persona $persona){

        $persona->usuario()->create([
            'usuario'=>$request->usuario,
            'contrasena'=>md5($request->contrasena),
            'perfil_id'=>$request->perfil,
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

    public function resetear(Request $request,User $usuario){
            $nueva_contrasena = $this->generateRandomString(8);
            $usuario->contrasena = md5($nueva_contrasena);
            $usuario->save();
            return view('usuario.partials.nueva-contrasena',compact('usuario','nueva_contrasena'));
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
