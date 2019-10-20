<!--
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">


        </div>

        <div class="box-body no-padding">



        </div>


    </div>

</div>
-->
<div class="panel box">
        <div class="box-header with-border" data-toggle="collapse" href="#collapseContactabilidad" aria-expanded="true">
            <div class="content-title">
                <h4 class="box-title">
                    ANÁLISIS REGISTRADOS
                </h4>
            </div>
            <div class="content-icon">
                <span class="collapse-icon fa fa-angle-up"></span>
            </div>
        </div>
        <div id="collapseContactabilidad" class="panel-collapse collapse in" aria-expanded="true" style="">
            <div class="box-body">

                    <div class="mailbox-controls">
                        <a href="#" data-url="{{route('registro-analisis.crear-form','persona_id')}}" id="btn-nuevo"> <i class="fa fa-plus"></i> Registrar nuevo análsis
                        </a>
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
                                    <td>{{$registro->id}}</td>
                                    <td>{{$registro->paciente->nombre_completo}}</td>
                                    <td>{{$registro->paciente->numero_documento}}</td>
                                    <td>{{$registro->medico->nombre_completo}}</td>
                                    <td>{{optional($registro->usuario)->usuario}}</td>
                                    <td>{{$registro->fecha_registro}}</td>
                                    <td>
                                        <button title="Ver detalle" class="btn btn-xs btn-success"><i class="fa fa-search-plus"></i></button>
                                        <button title="Editar" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></button>
                                        <button title="Imprimir" class="btn btn-xs btn-default"><i class="fa fa-print"></i></button>
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

