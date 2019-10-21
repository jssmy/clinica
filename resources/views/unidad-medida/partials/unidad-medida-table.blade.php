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
                    <button data-url="{{route('unidad-medida.crear-form')}}" id="btn-nuevo-unidad-medida"  type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> NUEVO</button>
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
                    @forelse($unidades as $unidad)
                        <tr>
                            <td>{{$unidad->nombre}}</td>
                            <td>{{$unidad->descripcion}}</td>
                            <td>
                                <label class='label label-{{$unidad->es_activo ? "info" : "danger"}}'>{{$unidad->es_activo ? 'ACTIVO' : 'INACTIVO'}}</label>
                            </td>
                            <td>{{$unidad->usuario ? $unidad->usuario->usuario : ''}}</td>
                            <td>{{$unidad->fecha_registro->format('d/m/Y')}}</td>
                            <td>
                                @if($unidad->es_activo)
                                    <button data-accion="inactivar" data-url="{{route('unidad-medida.editar.estado',['inactivar',$unidad])}}"  title='Inactivar' class="btn btn-xs btn-default btn-actualizar-estado"><i class='fa fa-remove'></i></button>
                                @else
                                    <button data-accion="activar" data-url="{{route('unidad-medida.editar.estado',['activar',$unidad])}}"  title='Activar' class="btn btn-xs btn-default btn-actualizar-estado"><i class='fa fa-check'></i></button>
                                @endif
                                <button data-url="{{route('unidad-medida.editar-form',$unidad)}}" title='Editar' class="btn btn-xs btn-default btn-editar-form"><i class='fa fa-pencil'></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center"><td colspan="6">No hay unidades de medidas registrados</td></tr>
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
                {!! $unidades->render() !!}
            </div>
        </div>
    </div>
    <!-- /. box -->
</div>
