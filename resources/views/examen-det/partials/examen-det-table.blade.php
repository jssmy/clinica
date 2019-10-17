<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="box-tools pull-right">

            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <div class="mailbox-controls">
                <!-- Check all button -->
                <div class="btn-group">
                    <button data-url="{{route('examen-det.crear-form')}}" id="btn-nuevo" type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> NUEVO</button>
                </div>
                <!-- /.pull-right -->
            </div>
            <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped" style="font-size:13px;">
                    <thead style="background-color: #3c8dbc; color: white">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Usuario Registro</th>
                        <th>Fecha Registro</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($examenes as $examen)
                        <tr>
                            <td>{{$examen->nombre}}</td>
                            <td>{{$examen->descripcion}}</td>
                            <td><label class='label label-{{$examen->es_activo ? "info" : "danger"}}'>{{$examen->es_activo ? 'ACTIVO' : 'INACTIVO'}}</label></td>
                            <td>#</td>
                            <td>{{$examen->fecha_registro}}</td>
                            <td>
                                @if($examen->es_activo)
                                    <button data-accion="inactivar" data-url="{{route('examen-det.editar.estado',['inactivar',$examen])}}"  title='Inactivar' class="btn btn-xs btn-default btn-actualizar-estado"><i class='fa fa-remove'></i></button>
                                @else
                                    <button data-accion="activar" data-url="{{route('examen-det.editar.estado',['activar',$examen])}}"  title='Activar' class="btn btn-xs btn-default btn-actualizar-estado"><i class='fa fa-check'></i></button>
                                @endif
                                <button data-url="{{route('examen-det.editar-form',$examen)}}" title='Editar' class="btn btn-xs btn-default btn-editar-form"><i class='fa fa-pencil'></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center"><td colspan="4">No hay estados registrados</td></tr>
                    @endforelse
                    </tbody>
                </table>
                <!-- /.table -->
            </div>
            <!-- /.mail-box-messages -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-padding">
            <div class="mailbox-controls">
                {{$examenes->render()}}
            </div>
        </div>
    </div>
    <!-- /. box -->
</div>
