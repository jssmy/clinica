@extends('layouts.app')
@section('title','Unidades de Medida')
@section('content')
    <section id="search-section">
        <!-- title row -->
        <div class="row">
            <div style="padding-bottom: 24px" class="text-center">
                <span class="page-header text-info" style="font-size: 37px; color: #337ab7;">
                    <span class="fa  fa-check-circle"></span> Unidad de medida
                </span>
            </div>
        </div>
        <!-- info row -->
    </section>
   <section>
       <div id="index-table" class="row">
           @include('unidad-medida.partials.unidad-medida-table')
       </div>
   </section>
@endsection
@section('scripts')
    <script id="crear-nuevo" type="text/template">
    @include('unidad-medida.modals.crear-unidad-medida')
    </script>
    <script src="{{URL::asset('public/plugins/bootbox/bootbox.min.js')}}"></script>
    <script>
        var url_index ="{{route('unidad-medida.index')}}";
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
                                className: 'btn btn-default btn-sm btn-info btn-actualizar-tipo-seguro',
                                callback: function(){
                                    var form = $("#form-tipo-seguro-update");
                                    if(!form.valid()) return false;
                                    var url = form.attr('action');
                                    var btn = $(".btn-actualizar-tipo-seguro");
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

        $(document).on('click','#btn-nuevo-unidad-medida',function () {
            var url = $(this).data('url');
            var btn_nuevo = $(this);

            var dialog = bootbox.dialog({
                title: "<b>Nuevo Unidad de Medida</b>",
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
                            var form = $("#form-tipo-seguro-store");

                            if(!form.valid()) return false;
                            var url = form.attr('action');
                            var btn = $(".btn-guardar-tipo");
                            $.ajax({
                                url : url,
                                type : 'post',
                                data : form.serializeArray(),
                                beforeSend: function () {
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
                message: "<b>¿Estás seguro de "+accion+" la unidad de medida?</b>",
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
        $(document).on("click","a", function (e) {
            if($(this).parent().parent().hasClass('pagination')){
                if($(this).hasClass('disabled')) return  false;
                $(this).addClass('disabled');
                url_index = $(this).attr('href');
                load_table();
                return false;
            };

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
