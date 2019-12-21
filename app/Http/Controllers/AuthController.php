<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
class AuthController extends Controller
{
    protected $route;

    public function __construct()
    {

    }

    public function loginForm(){

        if(Auth::check()) return redirect()->route('clinica.index');
        return view('layouts.login');
    }

    public function login(Request $request){
        $usuario = $this->user();

        if(!$usuario) return redirect()->route('login-form')->with(['invalid'=>'Las credenciales son incorrectas']);

        if($usuario->nuevo){
            return redirect()->route('login.lockscreen',$usuario);
        }

        auth()->guard()->login($usuario);

        return redirect()->route('clinica.index');
    }

    protected function user()
    {
        return User::where('usuario',\request()->usuario)
                    ->where('contrasena',md5(\request()->contrasena))->first();

    }

    public function logout(Request $request){
        if(\auth()->check()){
            \auth()->logout();
        }
        $request->session()->flush();
        return redirect()->route('login-form');
    }

    public function lockscreen(User $usuario){
        return view('layouts.lockscreen',compact('usuario'));
    }

    public function nuevaContrasena(Request $request,User $usuario){
        $usuario->contrasena = md5($request->contrasena);
        $usuario->nuevo =0;
        $usuario->save();
        return response()->json(['message'=>"Se ha cambiado la contraseña"]);
    }


}
