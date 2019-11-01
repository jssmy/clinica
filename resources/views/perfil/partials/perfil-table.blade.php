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
                        <a style="padding-top: 10px;" href="#"  data-url="{{route('perfil.crear-form')}}" id="btn-nuevo"> <i class="fa fa-plus"></i> Registrar nuevo perfil
                        </a>
                    </div>
                </div>
                <!-- /.pull-right -->
            </div>
            <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped" style="font-size:13px;">
                    <thead style="background-color: #3c8dbc; color: white">
                    <tr>
                        <th>Perfil</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Usuario Registro</th>
                        <th>Fecha Registro</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($perfiles as $perfil)
                        <tr>
                            <td>{{$perfil->id}}</td>
                            <td>{{$perfil->descripcion}}</td>
                            <td><label class='label label-{{$perfil->es_activo ? "info" : "danger"}}'>{{$perfil->es_activo ? 'ACTIVO' : 'INACTIVO'}}</label></td>
                            <td>{{$perfil->usuario? $perfil->usuario->usuario : ''}}</td>
                            <td>{{$perfil->fec_registro? $perfil->fec_registro->format('d/m/Y') : ''}}</td>
                            <td>
                                @if($perfil->es_activo)
                                    <button data-accion="inactivar" data-url="{{route('perfil.editar.estado',['inactivar',$perfil])}}"  title='Inactivar' class="btn btn-xs btn-default btn-actualizar-estado"><i class='fa fa-remove'></i></button>
                                @else
                                    <button data-accion="activar" data-url="{{route('perfil.editar.estado',['activar',$perfil])}}"  title='Activar' class="btn btn-xs btn-default btn-actualizar-estado"><i class='fa fa-check'></i></button>
                                @endif
                                <button data-url="{{route('perfil.editar-form',$perfil)}}" title='Editar' class="btn btn-xs btn-default btn-editar-form"><i class='fa fa-pencil'></i></button>
                            </td>

                        </tr>
                    @empty
                        <tr class="text-center"><td colspan="4">No hay perfiles registrados</td></tr>
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
                {!! $perfiles->render() !!}
            </div>
        </div>
    </div>
    <!-- /. box -->
</div>
