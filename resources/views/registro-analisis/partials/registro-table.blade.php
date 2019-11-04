<div class="panel box">
        <div class="box-header with-border" data-toggle="collapse" href="#" aria-expanded="true">
            <div class="content-title">
                <h4 class="box-title">
                    ANÁLISIS REGISTRADOS <span class="badge" style="background-color: #5cc500;"> {{$registros->total()}}</span>
                </h4>

            </div>
            <div class="content-icon">
                <span class="collapse-icon fa fa-angle-up"></span>
            </div>
        </div>
        <div id="collapseContactabilidad" class="panel-collapse collapse in" aria-expanded="true" style="">
            <div class="box-body">
                    <div class="mailbox-controls">
                        <div class="row">
                            <div class="col-sm-6">
                                @if($persona->paciente && !auth()->user()->esTecnologo)
                                    <a style="padding-top: 10px;" href="#" data-url="{{route('registro-analisis.crear-form','persona_id')}}" id="btn-nuevo"> <i class="fa fa-plus"></i> Registrar nuevo análsis
                                    </a>
                                @elseif(!$persona->paciente)
                                    <span style="cursor: pointer" title="Por favor registro el número de historia clínica del paciente" class="label label-warning">SIN HISTORIAL CLÍNICO</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped" style="font-size:13px;">
                            <thead style="background-color: #3c8dbc; color: white">
                            <tr>
                                <th>Código</th>
                                <th>Paciente</th>
                                <th>DNI</th>
                                <th>Médico</th>
                                <th>Usuario</th>
                                <th>Fecha registro</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($registros as $registro)
                                <tr>
                                    <td>{{$registro->codigo}}</td>
                                    <td>{{$registro->paciente->nombre_completo}}</td>
                                    <td>{{$registro->paciente->numero_documento}}</td>
                                    <td>{{$registro->medico? $registro->medico->nombre_completo : ''}}</td>
                                    <td>{{$registro->usuario? $registro->usuario->usuario : ''}}</td>
                                    <td>{{$registro->fecha_registro}}</td>
                                    <td>
                                        <button data-url="{{route('registro.analisis.resultados',$registro->id)}}"
                                                title="Ver resultados"
                                                class="btn btn-xs btn-success btn-ver-resultados">
                                            <i class="fa fa-search-plus"></i>
                                        </button>
                                        @if(!$registro->es_aprobado && !auth()->user()->esTecnologo)
                                            <button data-url="{{route('registro.analisis.cambiar',$registro->id)}}" title="Cambiar de paciente" class="btn btn-xs btn-info btn-cabiar-paciente"><i class="fa fa-share"></i></button>
                                        @endif
                                        @if(auth()->user()->esTecnologo)
                                            <a href="{{route('registro.analsis.imprimir',[$registro,'resultado=true'])}}" target="_blank" title="Imprimir registro de análisis con resultados" class="btn btn-xs btn-default"><i class="fa fa-print"></i></a>
                                        @else
                                            <a href="{{route('registro.analsis.imprimir',$registro)}}" target="_blank" title="Imprimir registro de análisis" class="btn btn-xs btn-default"><i class="fa fa-print"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @empty <tr class="text-center"><td colspan="7">No hay registrados</td></tr>
                            @endforelse
                            </tbody>
                        </table>

                    </div>

            </div>
            <div class="box-footer no-padding">
                <div class="mailbox-controls">
                    {!! $registros->render() !!}
                </div>
            </div>
        </div>
    </div>
