<div class="col-sm-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="mailbox-controls">
                <div class="row">
                    <div class="col-sm-6">
                        <a style="padding-top: 10px;" href="#" data-url="{{route('tipo-aseguro.crear-form')}}" id="btn-nuevo-tipo-seguro"> <i class="fa fa-plus"></i> Registrar nuevo tipo de seguro
                        </a>
                    </div>
                </div>
                <!-- /.pull-right -->
            </div>
            <div  class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped" style="font-size:12px;">
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
                    @forelse($tipoSeguros as $tipo)
                        <tr>
                            <td class='mailbox-name'>{{$tipo->nombre}}</td>
                            <td title="{{$tipo->descripcion}}"  >{{$tipo->descripcion}}</td>
                            <td>
                                <label class='label label-{{$tipo->es_activo ? "info" : "danger"}}'>{{$tipo->es_activo ? 'ACTIVO' : 'INACTIVO'}}</label>
                            </td>
                            <td>{{$tipo->usuario? $tipo->usuario->usuario : ''}}</td>
                            <td>{{$tipo->fecha_registro->format('d/m/Y')}}</td>
                            <td>
                                @if($tipo->es_activo)
                                    <button data-accion="inactivar" data-url="{{route('tipo-seguro.editar.estado',['inactivar',$tipo])}}"  data-tipo='{{$tipo->id}}' title='Inactivar' class="btn btn-xs btn-default btn-actualizar-estado"><i class='fa fa-remove'></i></button>
                                @else
                                    <button data-accion="activar" data-url="{{route('tipo-seguro.editar.estado',['activar',$tipo])}}" data-tipo='{{$tipo->id}}' title='Activar' class="btn btn-xs btn-default btn-actualizar-estado"><i class='fa fa-check'></i></button>
                                @endif
                                <button  data-url="{{route('tipo-seguro.editar-form',$tipo)}}"  data-tipo='{{$tipo->id}}' title='Editar' class="btn btn-xs btn-default btn-editar-form"><i class='fa fa-pencil'></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                        <tr class="text-center"><td colspan="6">No hay tipos de seguros registrados</td></tr>
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
                {!! $tipoSeguros->render() !!}
            </div>
        </div>
    </div>
</div>
