<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\QueryIndicador;
use Carbon\Carbon;
use http\Env\Url;
use Illuminate\Http\Request;
use function Sodium\library_version_major;

class IndicadorController extends Controller
{
    //
    public function __construct(Request $request){
        if(empty($request->all())){
            $request->merge(['fecha_resultado'=>Carbon::now()->subMonth()->format('d/m/Y')."-".Carbon::now()->format('d/m/Y')]);
        }
    }

    use QueryIndicador;
    public function indicadorUno(Request $request){
        list($fecha_inicio,$fecha_fin) = explode('-',str_replace(" ","",$request->fecha_resultado));
        $fecha_inicio =Carbon::createFromFormat('d/m/Y',$fecha_inicio);
        $fecha_fin =Carbon::createFromFormat('d/m/Y',$fecha_fin);
        $resultados = self::getUno($fecha_inicio,$fecha_fin);

        if($request->ajax()){
            return view('indicador.partials.resultado-uno',compact('resultados'));
        }
        return view('indicador.uno',compact('resultados'));
    }


    public function indicadorDos(Request $request){
        list($fecha_inicio,$fecha_fin) = explode('-',str_replace(" ","",$request->fecha_resultado));
        $fecha_inicio =Carbon::createFromFormat('d/m/Y',$fecha_inicio);
        $fecha_fin =Carbon::createFromFormat('d/m/Y',$fecha_fin);
        $resultados = self::getDos($fecha_inicio,$fecha_fin);
        if($request->ajax()){
            return view('indicador.partials.resultado-dos',compact('resultados'));
        }
        return view('indicador.dos',compact('resultados'));
    }


}
