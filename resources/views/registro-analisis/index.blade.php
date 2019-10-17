@extends('layouts.app')
@section('title','Registros')
@section('content')
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
                        <button data-url="{{route('registro-analisis.crear-form')}}" id="btn-nuevo" type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> NUEVO</button>
                    </div>
                    <!-- /.pull-right -->
                </div>
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped" style="font-size:13px;">
                        <thead style="background-color: #3c8dbc; color: white">
                        <tr>
                            <th>Código</th>
                            <td>Paciente</td>
                            <td>DNI</td>
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
                                <td>{{optional($registro->paciente)->nombre_completo}}</td>
                                <td>{{optional($registro->paciente)->numero_documento}}</td>
                                <td>{{optional($registro->medico)->nombre_completo}}</td>
                                <td>#</td>
                                <td>{{$registro->fecha_registro}}</td>
                                <td></td>
                            </tr>
                            @empty <tr class="text-center"><td colspan="7">No hay registrados</td></tr>
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
                    {!! $registros->render() !!}
                </div>
            </div>
        </div>
        <!-- /. box -->
    </div>
@endsection
@section('scripts')
    <script id="tpl-registro-paciente" type="text/template">
        @include('registro-analisis.modals.crear-registro-analisis')
    </script>
    <script src="{{URL::asset('public/plugins/bootbox/bootbox.min.js')}}"></script>
    <script>
        $(".btn-editar-form").on('click',function(){

            var url =  $(this).data('url');

            $.ajax({
                url: url,
                type : 'get',
                success: function (view) {
                    var dialog = bootbox.dialog({
                        title: "<b>Sub-tipo Examen</b>",
                        message: view,
                        size: 'medium',
                        buttons: {
                            cancel: {
                                label: "CANCELAR",
                                className: 'btn btn-sm btn-default',
                                callback: function(){
                                    console.log('Custom cancel clicked');
                                }
                            },
                            ok: {
                                label: "GUARDAR",
                                className: 'btn btn-default btn-sm btn-info btn-actualizar',
                                callback: function(){
                                    var form = $("#form-update");
                                    var url = form.attr('action');
                                    var btn = $(".btn-actualizar");
                                    $.ajax({
                                        url : url,
                                        type : 'put',
                                        data : form.serializeArray(),
                                        success: function (message) {

                                        },beforeSend: function () {
                                            btn.html("<i class='fa  fa-circle-o-notch fa-spin'> </i> GUARDANDO");
                                            btn.attr('disabled',true);
                                        }, complete: function () {
                                            btn.html('GUARDAR');
                                            btn.removeAttr('disabled');
                                        }
                                    });
                                    return false;
                                }
                            }
                        }
                    });
                }
            });


        });

        $("#btn-nuevo").on('click',function () {
            if($(this).is(":disabled")) return false;
            var url = $(this).data('url');
            var btn_nuevo = $(this);


            var dialog = bootbox.dialog({
                title: "<b>Nuevo análisis</b>",
                message: $("#tpl-registro-paciente").html(),
                size: 'large',
                buttons: {
                    cancel: {
                        label: "CANCELAR",
                        className: 'btn btn-sm btn-default',
                        callback: function(){
                            console.log('Custom cancel clicked');
                        }
                    },
                    ok: {
                        label: "GUARDAR",
                        className: 'btn btn-default btn-sm btn-info btn-guardar-nuevo',
                        callback: function(){
                            var form = $("#form-store");
                            var url = form.attr('action');
                            var btn = $(".btn-guardar-nuevo");
                            $.ajax({
                                url : url,
                                type : 'post',
                                data : form.serializeArray(),
                                success: function (message) {

                                },beforeSend: function () {
                                    btn.html("<i class='fa  fa-circle-o-notch fa-spin'> </i> GUARDANDO");
                                    btn.attr('disabled',true);
                                }, complete: function () {
                                    btn.html('GUARDAR');
                                    btn.removeAttr('disabled');
                                }
                            });
                            return false;
                        }
                    }
                }
            });
            /*
            $.ajax({
                url: url,
                type:'get',
                success: function (view) {

                    $("#btn-registra-empleado").trigger('click');
                }, beforeSend: function () {
                    btn_nuevo.html("<i class='fa  fa-circle-o-notch fa-spin'> </i> NUEVO");
                    btn_nuevo.attr('disabled',true);
                }, complete: function () {
                    btn_nuevo.html('NUEVO');
                    btn_nuevo.removeAttr('disabled');
                }
            });
            */

        });

        $(".btn-actualizar-estado").on('click',function () {
            var url = $(this).data('url');
            var accion = $(this).data('accion');

            var dialog = bootbox.dialog({
                title: "<b>¡ALERTA!</b>",
                message: "<b>¿Estás seguro de "+accion+" el sub-tipo de examen?</b>",
                size: 'medium',
                buttons: {
                    cancel: {
                        label: "CANCELAR",
                        className: 'btn btn-sm btn-default',
                        callback: function(){

                        }
                    },
                    ok: {
                        label: "CONFIRMAR",
                        className: 'btn btn-default btn-sm btn-info btn-confirmar-actualizacion-estado',
                        callback: function(){
                            var btn = $(".btn-confirmar-actualizacion-estado");
                            $.ajax({
                                url: url,
                                type: 'put',
                                data: {_token : $("#_token").val()},
                                success: function (message) {

                                },
                                beforeSend: function () {
                                    btn.html("<i class='fa  fa-circle-o-notch fa-spin'> </i> ESPERE");
                                    btn.attr('disabled',true);
                                },complete: function () {
                                    btn.html('CONFIRMAR');
                                    btn.removeAttr('disabled');
                                }
                            });
                            return false;
                        }
                    }
                }
            });
        });
    </script>
@endsection
