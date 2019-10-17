@extends('layouts.app')
@section('title','Insumos')
@section('content')
    <div id="index-table" class="row">
        @include('insumo.partials.insumo-table')
    </div>
@endsection
@section('scripts')
    <script id="crear-nuevo" type="text/template">
    @include('insumo.modals.crear-insumo')
    </script>
    <script src="{{URL::asset('public/plugins/bootbox/bootbox.min.js')}}"></script>
    <script>
        var url_index ="{{route('insumo.index')}}";

        $(document).on('click','.btn-editar-form',function(){

            var url =  $(this).data('url');

            $.ajax({
                url: url,
                type : 'get',
                success: function (view) {
                    var dialog = bootbox.dialog({
                        title: "<b>Unidad de Medida</b>",
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
                                    var form = $("#form-update")
                                    if(!form.valid()) return false;
                                    var url = form.attr('action');
                                    var btn = $(".btn-actualizar");
                                    $.ajax({
                                        url : url,
                                        type : 'put',
                                        data : form.serializeArray()
                                        ,beforeSend: function () {
                                            btn.html("<i class='fa  fa-circle-o-notch fa-spin'> </i> GUARDANDO");
                                            btn.attr('disabled',true);
                                        }, complete: function () {
                                            btn.html('GUARDAR');
                                            btn.removeAttr('disabled');
                                            load_table();
                                        }
                                    });
                                }
                            }
                        }
                    });
                }
            });
        });

        $(document).on('click','#btn-nuevo-insumo',function () {
            if($(this).is(":disabled")) return false;
            var url = $(this).data('url');
            var btn_nuevo = $(this);

            var dialog = bootbox.dialog({
                title: "<b>Nuevo Insumo</b>",
                message: $("#crear-nuevo").html(),
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
                        className: 'btn btn-default btn-sm btn-info btn-guardar-tipo',
                        callback: function(){
                            var form = $("#form-store");

                            if(!form.valid()) return false;

                            var url = form.attr('action');
                            var btn = $(".btn-guardar-tipo");
                            $.ajax({
                                url : url,
                                type : 'post',
                                data : form.serializeArray()
                                ,beforeSend: function () {
                                    btn.html("<i class='fa  fa-circle-o-notch fa-spin'> </i> GUARDANDO");
                                    btn.attr('disabled',true);
                                }, complete: function () {
                                    btn.html('GUARDAR');
                                    btn.removeAttr('disabled');
                                    load_table();
                                }
                            });

                        }
                    }
                }
            });

        });

        $(document).on('click','.btn-actualizar-estado',function () {
            var url = $(this).data('url');
            var accion = $(this).data('accion');

            var dialog = bootbox.dialog({
                title: "<b>¡ALERTA!</b>",
                message: "<b>¿Estás seguro de "+accion+" el insumo?</b>",
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
                                beforeSend: function () {
                                    btn.html("<i class='fa  fa-circle-o-notch fa-spin'> </i> ESPERE");
                                    btn.attr('disabled',true);
                                },complete: function () {
                                    btn.html('CONFIRMAR');
                                    btn.removeAttr('disabled');
                                    load_table();
                                }
                            });

                        }
                    }
                }
            });
        });
        $(document).on("click","ul.pagination li.page-item a", function (e) {
            if($(this).hasClass('disabled')) return  false;
            $(this).addClass('disabled');
            url_index = $(this).attr('href');
            load_table();
            return false;
        });
        function load_table(){
            $.ajax({
                url: url_index,
                type:'get',
                success: function (view) {
                    $("#index-table").html(view);
                }
            });
        }
    </script>
@endsection
