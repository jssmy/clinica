@extends('layouts.app')
@section('title','Personas')
@section('content')
    <section id="search-section" >
        <!-- title row -->

        <div class="row">
            <div style="padding-bottom: 24px" class="text-center">
                <span class="page-header text-info"  style="font-size: 37px; color: #337ab7;">
                    <i class="fa  {{$tipo_persona=='medico' ? 'fa-user-md' : 'fa-stethoscope' }}"></i> Gestión de {{$tipo_persona=='medico' ? 'Médico' : 'Paciente'}}
                </span>
            </div>
        </div>
        <!-- info row -->
        <div class="row">
            <div style=" display: flex; justify-content: center;">
                <div style="min-width: 300px; width: 50%" class="invoice-col">
                    <div class="input-group input-group-lg">
                        <div class="input-group-btn">
                            <button class="btn btn-default" style="color: #fff;background: #31708f;font-size: 14px;">Nro. documento</button>
                        </div>
                        <!-- /btn-group -->
                        <input data-btn="btn-consultar" id="txt-numero" type="text" name="numero" class="input-submit form-control input-digits" placeholder="buscar {{$tipo_persona=='medico' ? 'médico' : 'paciente'}}">
                        <div class="input-group-btn">
                            <button id="btn-consultar"
                                    data-search="<span class='fa fa-search' style='color: #fff;background: #31708f;'></span>"
                                    data-loading="<i class='fa fa-circle-o-notch fa-spin'></i> Buscando"
                                    class="btn btn-default"
                                    data-url="{{route('persona.dato.personal',$tipo_persona)}}"
                                    title="buscar..." style="color: #fff;background: #31708f; font-size: 15px">
                                <span class="fa fa-search" style="color: #fff;background: #31708f;"></span>
                            </button>
                        </div>
                    </div>
                    <div style="margin-top: 15px;">
                        <a style="margin-top: 30px;" href="{{route('persona.crear-form',$tipo_persona)}}"  > <i class="fa fa-plus"></i> Registrar nuevo {{$tipo_persona=='medico' ? 'médico' : 'paciente'}}
                        </a>
                    </div>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <div id="message">

        </div>
    </section>

    <div id="main-section"  style="padding-top: 0px; background: transparent; border: 0px;">

    </div>
@endsection
@section('scripts')
    <script src="{{URL::asset('public/plugins/bootbox/bootbox.min.js')}}"></script>
    <script>
        var url_index ="{{route('persona.index',$tipo_persona)}}";

        $(document).on('click',".btn-editar-form",function(){

            var url =  $(this).data('url');

            $.ajax({
                url: url,
                type : 'get',
                success: function (view) {
                    var dialog = bootbox.dialog({
                        title: "<b>Persona</b>",
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
                                    if(!form.valid()) return false;

                                    var url = form.attr('action');
                                    var btn = $(".btn-actualizar");
                                    $.ajax({
                                        url : url,
                                        type : 'put',
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
                    $(".input-digits").inputFilter(function (value) {
                        return format_digits(value);
                    });
                }
            });


        });

        $(document).on('click',".btn-actualizar-estado",function () {
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

        var params={};
        $(document).on('click','#btn-consultar', function () {

            if ($("#txt-numero").val() == ""){
                return false;
            }
            var url = $(this).data('url');
            $('#message').html('');
            var btn = $(this);
            params.numero_documento = $("#txt-numero").val();
            params.section='edit_persona';
            $.ajax({
                url: url,
                type: 'get',
                data: params,
                success: function (view){
                    $("#main-section").html(view);
                    $('#main-section').fadeIn();
                    $('#search-section').fadeOut();
                    params.persona = JSON.parse($("#hdh-persona").val());
                },
                beforeSend: function(){
                    btn.html("<i class='fa fa-circle-o-notch fa-spin'></i> Buscando");
                    btn.attr('disabled', true);
                },
                complete: function(){
                    btn.html('<span class="fa fa-search" style="color: #fff;background: #31708f;"></span>');
                    btn.removeAttr('disabled');
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
            }

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
