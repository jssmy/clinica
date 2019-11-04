<div class="row">
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

                </div>
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped" style="font-size:12px;">
                        <thead style="background-color: #3c8dbc; color: white">
                        <tr>
                            <th>DNI</th>
                            <th>Nombres</th>
                            <th>Fecha Nacimiento</th>
                            <th>Dirección</th>
                            <th>Género</th>
                            <th>Estado civil</th>
                            <th>Teléfono</th>
                            <th>Usuario registro</th>
                            <th>Fecha registro</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($personas as $persona)
                            <tr>
                                <td>{{$persona->numero_documento}}</td>
                                <td>{{$persona->nombre_completo}}</td>
                                <td>{{date("d/m/Y",strtotime($persona->fecha_nacimiento))}}</td>
                                <td>{{$persona->direccion}}</td>
                                <td>{{$persona->genero_completo}}</td>
                                <td>{{$persona->estadoCivil ? $persona->estadoCivil->nombre : ''}}</td>
                                <td>{{$persona->telefono}}</td>
                                <td>{{$persona->usuario_accion? $persona->usuario_accion->usuario : ''}}</td>
                                <td>{{ $persona->fec_registro->format('d/m/Y')  }}</td>
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
                    {!! $personas->render() !!}
                </div>
            </div>
        </div>
        <!-- /. box -->
    </div>

</div>
