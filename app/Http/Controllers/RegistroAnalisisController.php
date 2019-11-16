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

use App\Models\Semaforizacion;
use App\Utils\fpdf\FPDF;
use App\Utils\FPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use function foo\func;

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
                    if($insumo){
                        $insumo->cantidad = (int)$insumo->cantidad - 1;
                        $insumo->save();
                    }

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
                $analisis = RegistroAnalisis::with(['resultados.tipoExamen','resultados.subTipoExamen'])->find($analisis_id);

        return view('registro-analisis.modals.resultados-analisis',compact('analisis'));
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

    public function guardarResultadoAnalisis(Request $request, RegistroAnalisis $analisis){

        \DB::transaction(function () use ($request,$analisis){
            $resultados = $request->resultado;
            foreach ($resultados as $resultado => $item){
                RestultadoAnalisis::where('id',$resultado)->update([
                    'comentario'=>$item['comentario'],
                    'resultado'=>$item['valor']
                ]);
            }
            if(!$analisis->es_aprobado){
                $analisis->resultados()->update([
                    'usuario_resultado_id'=>auth()->id(),
                    'fecha_resultado'=>date("Y-m-d h:i:s",strtotime( '-1 days' ))
                ]);
                $analisis->estado='AP';
                $analisis->usuario_resultado_id = auth()->id();
                $analisis->fecha_resultado = date("Y-m-d h:i:s",strtotime( '-1 days' ));
                $analisis->save();
            }
        });
        return response()->json(['message'=>'Se ha guardado correctamente','resultado_analisis'=>$analisis]);
    }

    public function semoforizacionForm(){
        $semaforizacion = Semaforizacion::all();
        return view('registro-analisis.modals.semaforizacion',compact('semaforizacion'));
    }

    public function semoforizacionStore(Request $request){
        \DB::transaction(function () use ($request){

            Semaforizacion::whereIn('id',array_keys($request->semaforo))->delete();
            Semaforizacion::insert($request->semaforo);
        });
        return response()->json(['message'=>'Se ha actualizado la semaforización']);
    }

    public function imprimir(RegistroAnalisis $analisis){
        $analisis = $analisis->load('paciente','medico');

        $pdf = new PDF();
        $pdf->AddPage();

        $pdf->Image(\URL::asset('/public/dist/img/logo.jpg'),19,8,20,18);
        $pdf->SetFont('Arial',NULL,8);
        $pdf->SetXY(137,9);
        $pdf->Cell(70,4,utf8_decode('Dirección: Mz c Lt 21-22 Canto Chico S.J.L'),0,'j');
        $pdf->SetXY(137,10);
        $pdf->cell(70,10,utf8_decode('Teléfono: (01) 3760431'),0,'j');
        $pdf->SetXY(137,14);
        $pdf->cell(70,10,utf8_decode('Email: cssantarosa@dirislimacentro.gob.pe'),0,'j');
        $pdf->SetXY(137,18);
        $pdf->cell(70,10,utf8_decode('RUC: 20602250602'),0,'j');
        /* registro de analisi* */
        $pdf->Ln(15);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('Arial','B',10);
        $pdf->SetX(16);
        $title=utf8_decode('REGISTRO DE ANÁLISIS');
        if(\request()->resultado){
            $title = utf8_decode("RESULTADO DE ANÁLISIS");
        }
        $pdf->Cell(177,7,$title,1,0,'C',1);
        $pdf->SetTextColor(0,0,0);
        /* datos generales  */
        $pdf->Ln(10);
        $pdf->SetX(16);
        $pdf->Cell(177,6,utf8_decode('DATOS GENERALES'),1,0,'C');
        $pdf->Ln(7);
        $pdf->SetX(16);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(15,9,utf8_decode("CÓDIGO:"));
        $pdf->SetFont('Arial',null,9);
        $pdf->Cell(80,9,$analisis->codigo);
        $title_fecha_registro=utf8_decode('FECHA DE REGISTRO:');
        $fecha_registr=date("d/m/Y h:i",strtotime($analisis->fecha_registro));
        if(\request()->resultado){
            $title_fecha_registro = utf8_decode("FECHA DE RESULTADO:");
            $fecha_registr = $analisis->fecha_resultado? date("d/m/Y h:i",strtotime($analisis->fecha_resultado)) : '';

        }
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(15,9,$title_fecha_registro);
        $pdf->SetFont('Arial',null,9);
        $pdf->SetX($pdf->GetX()+25);
        $pdf->Cell(15,9,$fecha_registr);
        /* usuario registro */
        $pdf->Ln(5);
        $pdf->SetX(16);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(15,9,"REGISTRADO POR: ");
        $pdf->SetX($pdf->GetX()+16);
        $pdf->SetFont('Arial',null,9);
        $pdf->Cell(80,9,utf8_decode($analisis->usuario->persona->nombre_completo));
        /* datos del paciente*/
        $pdf->Ln(7);
        $pdf->SetX(16);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(177,6,utf8_decode('DATOS DEL PACIENTE'),1,0,'C');
        /* nombre del paciente  */
        $pdf->Ln(7);
        $pdf->SetX(16);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(18,9,"NOMBRE:");
        $pdf->SetFont('Arial',null,9);
        $pdf->Cell(100,9,utf8_decode($analisis->paciente->nombre_completo));
        /* dni paciente */
        $pdf->Ln(5);
        $pdf->SetX(16);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(10,9,"DNI:");
        $pdf->SetFont('Arial',null,9);
        $pdf->Cell(55,9,utf8_decode($analisis->paciente->numero_documento));
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(17,9,utf8_decode("GÉNERO:"));
        $pdf->SetFont('Arial',null,9);
        $pdf->Cell(30,9,utf8_decode(strtolower($analisis->paciente->genero)=='m' ? 'Hombre' : 'Mujer'));
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(40,9,utf8_decode("FECHA DE NACIMIENTO:"));
        $pdf->SetFont('Arial',null,9);
        $pdf->Cell(55,9,date("d/m/Y",strtotime($analisis->paciente->fecha_nacimiento)));
        /**historia cinica */
        $pdf->Ln(5);
        $pdf->SetX(16);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(45,9,utf8_decode("NRO. HISTORIAL CLÍNICA:"));
        $pdf->SetFont('Arial',null,9);
        $pdf->Cell(55,9,utf8_decode($analisis->paciente->paciente ? $analisis->paciente->paciente->numero_historia_clinica : '-'));
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(30,9,utf8_decode("TIPO DE SEGURO: "));
        $pdf->SetFont('Arial',null,9);
        $pdf->Cell(55,9,utf8_decode($analisis->paciente->paciente ? $analisis->paciente->paciente->tipo_seguro->nombre : '-'));
        /* datos generales  */
        $pdf->Ln(7);
        $pdf->SetX(16);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(177,6,utf8_decode('DATOS DEL EXAMEN'),1,0,'C');
        $pdf->Ln(7);
        $pdf->SetX(16);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(38,9,utf8_decode("NOMBRE DEL MÉDICO: "));
        $pdf->SetFont('Arial',null,9);
        $pdf->Cell(55,9,utf8_decode($analisis->medico ? $analisis->medico->nombre_completo : '-'));
        $pdf->Ln(7);
        $pdf->SetX(16);
        $pdf->SetX(16);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(177,9,utf8_decode("EXÁMENES REALIZADOS"));
        $pdf->Ln(5);

        if(\request()->resultado){
            $this->conResultadoPdf($pdf,$analisis);
        }else {
            $this->sinResultadoPdf($pdf,$analisis);
        }
        $pdf->SetY($pdf->GetPageHeight()-30);
        $pdf->Line($pdf->GetPageWidth()-125,$pdf->GetPageHeight()-30,$pdf->GetPageWidth()-85,$pdf->GetPageHeight()-30);
        $pdf->SetFont('Arial',null,9);
        $pdf->SetX(55);
        $pdf->Cell(100,9,utf8_decode($analisis->medico ? $analisis->medico->nombre_completo : '-'),0,0,'C');
        $pdf->Output();
        exit;
    }

    private function conResultadoPdf($pdf,$analisis){
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
                $pdf->Cell(70,5,'SUB TIPO DE EXAMEN',1,0,'J',true);
                $pdf->Cell(70+27,5,'OBSERVACIONES',1,0,'J',true);

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
                    $pdf->Cell(70+27,20,'',1,0,'J',true);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(70+27,5,utf8_decode($found->comentario));



                    $pdf->SetXY($x+70+27,$y);
                    $pdf->Cell(10,20,'',1,0,'J',true);
                    $pdf->SetXY($x+70+27,$y);
                    $pdf->MultiCell(10,5,$found->resultado);
                    $pdf->Ln(15);
                }
            }
        }
    }
    private function sinResultadoPdf($pdf,$analisis){
        $examenes = $analisis->resultados->load('tipoExamen','subTipoExamen');
        $examenCab =collect();
        foreach ($examenes  as $index =>  $examen) {
            $examenFounded = $examenes->where('examen_cab_id',$examen->examen_cab_id);
            if($examenFounded->isNotEmpty() && !$examenCab->where('examen_cab_id',$examen->examen_cab_id)->count()){
                $pdf->Ln(5);
                $pdf->SetX(16);
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(30,9,utf8_decode("Tipo de examen: "));
                $pdf->SetFont('Arial',null,9);
                $pdf->Cell(60,9,strtoupper($examen->tipoExamen->nombre));
                $order = 1;
                foreach ($examenFounded as $index =>$found){
                    $pdf->Ln(6);
                    $pdf->SetX(20);
                    $pdf->Cell(70,4,$order.". ".utf8_decode(strtoupper($found->subTipoExamen->nombre)));
                    $order++;
                }
            }
        }
    }

}
