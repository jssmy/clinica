<?php

namespace App\Http\Controllers;

use App\Http\Requests\CambiarAnalisisRequest;
use App\Models\AnalisisTipoExamen;
use App\Models\EstadoCivil;
use App\Models\ExamenCab;
use App\Models\ExamenDet;
use App\Models\Insumo;
use App\Models\Persona;
use App\Models\RegistroAnalisis;
use App\Models\RestultadoAnalisis;

use App\Utils\fpdf\FPDF;
use App\Utils\FPDF\PDF;
use Illuminate\Http\Request;

class RegistroAnalisisController extends Controller
{
    //

    public function index(Request $request){

        return view('registro-analisis.index');
    }

    public function crearForm(Persona $persona){
        $tiposExamen  = ExamenCab::activo()->get();
        return view('registro-analisis.modals.crear-registro-analisis',compact('tiposExamen','persona'));
    }

    public function encontrarPersona($tipo,$numero_documento){
        $persona=null;
        if($tipo=='paciente'){
            $persona = Persona::with('paciente')
                ->soloPaciente()
                ->where('numero_documento',$numero_documento)
                ->first();
            if(!$persona){
                return response('elemento no encotrado',422);
            }

            //return view('registro-analisis.modals.partials.registro-persona',compact('persona'));
        }else if($tipo='medico'){
            $persona = Persona::where('numero_documento',$numero_documento)->soloMedico()->first();

            if(!$persona){
                return response('elemento no encotrado',422);
            }
        }
        return view('persona.partials.datos-personales',compact('persona'));
    }

    public function crear(Request $request){

        \DB::transaction(function () use ($request){
            $analisis=RegistroAnalisis::create([
                /* crear registro de analisis */
                'paciente_id'=>$request->paciente_id,
                'empleado_id'=>$request->medico_id,
                'usuario_id'=>auth()->user()->id,
                'codigo'=>RegistroAnalisis::generarCodigo(),
            ]);
            /*crear analisis + tipos de examne */
            $tipos_examen = $request->tipos_examen;

            foreach ($tipos_examen  as $examen_cab_id => $subTipos){
                foreach ($subTipos as $exmanen_det_id){
                    AnalisisTipoExamen::create([
                        'usuario_id'    => auth()->user()->id,
                        'analisis_id'   => $analisis->id,
                        'examen_cab_id' => $examen_cab_id,
                        'examen_det_id' => $exmanen_det_id,
                    ]);
                    $insumo = ExamenDet::find($exmanen_det_id)->insumo()->first();
                    $insumo->cantidad = (int)$insumo->cantidad - 1;
                    $insumo->save();
                }
            }
        });

        return response()->json(['message'=>'Se ha registrado correctamente el análisis']);
    }

    public function analisisTable(Request $request,Persona $persona){
        $persona = $persona->load('paciente');
        $registros = RegistroAnalisis::where('paciente_id',$persona->id)
                                            ->orderBy('fecha_registro','desc')
                                            ->paginate(8);

        return view('registro-analisis.partials.registro-table',compact('registros','persona'));
    }

    public function resultadosAnalisis($analisis_id){
                $resultados = RestultadoAnalisis::with('tipoExamen','subTipoExamen')
                        ->where('analisis_id',$analisis_id)
                        ->get();

        return view('registro-analisis.modals.resultados-analisis',compact('resultados'));
    }

    public function cambiarPacienteForm(RegistroAnalisis $analisis){
        $analisis = $analisis->load('medico');
        return view('registro-analisis.partials.cambiar-paciente',compact('analisis'));
    }

    public function cambiarPacienteStore(CambiarAnalisisRequest $request,RegistroAnalisis $analisis){
        $analisis->paciente_id = $request->paciente_id;
        $analisis->save();
        return response()->json(['message'=>'El análisis fue movido a otro paciente']);
    }

    public function guardarResultadoAnalisis(Request $request, RestultadoAnalisis $resultadoAnalisis){
        \DB::transaction(function () use ($request,&$resultadoAnalisis){
            $resultadoAnalisis->comentario = $request->comentario;
            $resultadoAnalisis->resultado = $request->resultado;
            $resultadoAnalisis->fecha_resultado=date("Y-m-d H:i:s");
            $analisis = $resultadoAnalisis->analisis;
            $resultadoAnalisis->save();
            if($analisis->aprobado) {
                $analisis->estado = 'AP';
                $analisis->save();
            }
        });

        return response()->json(['message'=>'Se ha guarado el resultado del examen','resultado_analisis'=>$resultadoAnalisis]);
    }

    public function imprimir(RegistroAnalisis $analisis){
        $analisis = $analisis->load('paciente','medico');

        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',14);
        $pdf->MultiCell(70,5,utf8_decode('Laboratorio Clínico C.S Santa Rosa'),0,'C');
        $pdf->SetFont('Arial',NULL,8);
        $pdf->SetXY(90,9);
        $pdf->Cell(70,4,utf8_decode('Av. Guardia Civil 421 - 433 San Miguel'),0,'j');
        $pdf->SetXY(90,10);
        $pdf->cell(70,10,utf8_decode('Teléfono: 12345678'),0,'j');
        $pdf->SetXY(90,14);
        $pdf->cell(70,10,utf8_decode('Email: email@example.com'),0,'j');
        $pdf->SetXY($pdf->GetX()-3,6);
        $pdf->cell(70,10,utf8_decode('Nro.: '.$analisis->codigo),0,'j');
        $pdf->Ln(20);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('Arial','B',10);
        $pdf->SetX(16);
        $pdf->Cell(177,7,utf8_decode('FORMULARIO DE EXÁMENES MÉDICOS'),1,0,'C',1);
        $pdf->Ln(10);
        $pdf->SetX(16);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial',null,9);
        $pdf->Cell(177,9,utf8_decode("Nombre del paciente:  ".$analisis->paciente->nombre_completo));
        $pdf->Line($pdf->GetPageWidth()-$pdf->GetX()+30,$pdf->GetY()+6,$pdf->GetPageWidth()-17.5,$pdf->GetY()+6);
        $pdf->Ln(7);
        $pdf->SetX(16);
        $pdf->Cell(60,9,utf8_decode("Fecha de nacimiento:  ".$analisis->paciente->fec_nacimiento->format('d/m/Y')));
        $pdf->Line($pdf->GetX()-28.5,$pdf->GetY()+6,$pdf->GetX()+20,$pdf->GetY()+6);
        $pdf->SetX($pdf->GetX()+37);
        $pdf->Cell(60,9,utf8_decode("Fecha de hoy:  ".date("d/m/Y")));
        $pdf->Line($pdf->GetX()-39,$pdf->GetY()+6,$pdf->GetX()+20,$pdf->GetY()+6);
        $pdf->Ln(7);
        $pdf->SetX(16);
        $pdf->Cell(177,9,utf8_decode("Nombre del médico  :  ".$analisis->medico->nombre_completo));
        $pdf->Line($pdf->GetPageWidth()-$pdf->GetX()+30,$pdf->GetY()+6,$pdf->GetPageWidth()-17.5,$pdf->GetY()+6);
        $pdf->Ln(10);
        $pdf->SetX(16);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(177,9,utf8_decode("EXÁMENES REALIZADOS"));
        $pdf->Ln(7);
        $pdf->SetX(16);
        $examenes = $analisis->resultados->load('tipoExamen','subTipoExamen');
        $examenCab =collect();
        foreach ($examenes  as $index =>  $examen) {
            $examenFounded = $examenes->where('examen_cab_id',$examen->examen_cab_id);
            if($examenFounded->isNotEmpty() && !$examenCab->where('examen_cab_id',$examen->examen_cab_id)->count()){
                $pdf->Ln(5);
                $pdf->SetX(16);
                $examenCab->push($examenFounded->first());;
                $pdf->SetFont('Arial','B',9);
                $pdf->SetFillColor(206, 206, 208); // establece el color del fondo de la celda (en este caso es AZUL
                $pdf->Cell(177,9,'Tipo de examen: '.strtoupper($examen->tipoExamen->nombre),1,0,'J',true);
                $pdf->Ln(9);
                $pdf->SetX(16);
                $pdf->SetFont('Arial',null,8);
                $pdf->SetFillColor(235, 236, 236); // establece el color del fondo de la celda (en este caso es AZUL
                $pdf->Cell(70,5,'DETALLE DE EXAMEN',1,0,'J',true);
                $pdf->Cell(70,5,'OBSERVACIONES',1,0,'J',true);
                $pdf->Cell(27,5,'FEC. RESULTADO',1,0,'J',true);
                $pdf->Cell(10,5,'Rtdo.',1,0,'J',true);
                $pdf->Ln(5);
                foreach ($examenFounded as $found){
                    $pdf->SetX(16);
                    $pdf->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es AZUL
                    $pdf->Cell(70,20,'',1,0,'L',true);
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();
                    $pdf->SetX(16);
                    $pdf->MultiCell(70,4,utf8_decode(strtoupper($found->subTipoExamen->nombre)));
                    $pdf->SetXY($x,$y);
                    $pdf->Cell(70,20,'',1,0,'J',true);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(70,5,utf8_decode($found->comentario));
                    $pdf->SetXY($x+70,$y);
                    $pdf->Cell(27,20,'',1,0,'J',true);
                    $pdf->SetXY($x+70,$y);
                    $pdf->MultiCell(27,5,$found->fec_resultado ? $found->fec_resultado->format('d/m/Y') : '');;

                    $pdf->SetXY($x+70+27,$y);
                    $pdf->Cell(10,20,'',1,0,'J',true);
                    $pdf->SetXY($x+70+27,$y);
                    $pdf->MultiCell(10,5,$found->resultado);
                    $pdf->Ln(15);
                }
            }
        }


        /*
        $pdf->SetFillColor(206, 206, 208); // establece el color del fondo de la celda (en este caso es AZUL
        $header=['EXAMEN','DETALLE','FECHA DE RESULTADO','RESULTADO'];
        foreach($header as $col){
            $pdf->Cell(44.2,7,$col,1,0,'C',true);
        }*/


        $pdf->Output();
        exit;
    }


}
