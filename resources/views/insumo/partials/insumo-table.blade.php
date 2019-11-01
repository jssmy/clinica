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
                <div class="row">
                    <div class="col-sm-6">
                        <a style="padding-top: 10px;" href="#" data-url="{{route('insumo.crear-form')}}" id="btn-nuevo-insumo"> <i class="fa fa-plus"></i> Registrar nuevo insumo
                        </a>
                    </div>
                </div>
                <!-- /.pull-right -->
            </div>
            <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped" style="font-size:13px;">
                    <thead style="background-color: #3c8dbc; color: white">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Unidad Medida</th>
                        <th>Uso</th>
                        <th>Cantidad</th>
                        <th>Estado</th>
                        <th>Usuario Registro</th>
                        <th>Fecha Registro</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($insumos as $insumo)
                        <tr>
                            <td class='mailbox-name'>{{$insumo->nombre}}</td>
                            <td title="{{$insumo->descripcion}}" style="cursor:pointer;" >{{$insumo->descripcion}}</td>
                            <td>{{$insumo->medida? $insumo->medida->nombre : ''}}</td>
                            <td>{{$insumo->tipo_examen ? $insumo->tipo_examen->nombre : '' }}</td>
                            <td>{{$insumo->cantidad}}</td>
                            <td>
                                <label class='label label-{{$insumo->es_activo ? "info" : "danger"}}'>{{$insumo->es_activo ? 'ACTIVO' : 'INACTIVO'}}</label>
                            </td>
                            <td>{{$insumo->usuario? $insumo->usuario->usuario : '' }}</td>
                            <td>{{$insumo->fecha_registro->format('d/m/Y')}}</td>
                            <td>
                                @if($insumo->es_activo)
                                    <button data-accion="inactivar" data-url="{{route('insumo.editar.estado',['inactivar',$insumo])}}"  title='Inactivar' class="btn btn-xs btn-default btn-actualizar-estado"><i class='fa fa-remove'></i></button>
                                @else
                                    <button data-accion="activar" data-url="{{route('insumo.editar.estado',['activar',$insumo])}}"  title='Activar' class="btn btn-xs btn-default btn-actualizar-estado"><i class='fa fa-check'></i></button>
                                @endif
                                <button data-url="{{route('insumo.editar-form',$insumo)}}" title='Editar' class="btn btn-xs btn-default btn-editar-form"><i class='fa fa-pencil'></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                        <tr class="text-center"><td colspan="6">No hay insumos registrados</td></tr>
                        </tr>
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
                {!! $insumos->render() !!}
            </div>
        </div>
    </div>
</div>
