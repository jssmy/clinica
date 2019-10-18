<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
class AuthController extends Controller
{
    protected $route;

    public function __construct()
    {

    }

    public function loginForm(){
        return view('layouts.login');
    }

    public function login(Request $request){
        $usuario = $this->user();
        if(!$usuario) return redirect()->route('login-form');

        auth()->guard()->login($usuario);
        return redirect()->route('clinica.index');
    }

    protected function user()
    {
        return User::where('usuario',\request()->usuario)
                    ->where('contrasena',md5(\request()->contrasena))->first();

    }



}
