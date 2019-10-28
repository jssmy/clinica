@extends('layouts.app')
@section('title','Registros')

@section('content')

    <section id="search-section" >
        <!-- title row -->

        <div class="row">
            <div style="padding-bottom: 24px" class="text-center">
                <span class="page-header text-info"  style="font-size: 37px; color: #337ab7;">
                    <i class="fa  fa-heartbeat"></i> Registro de análsis
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
                        <input data-btn="btn-consultar" id="txt-numero" type="text" name="numero" class="input-submit form-control input-digits" placeholder="buscar paciente">
                        <div class="input-group-btn">
                            <button id="btn-consultar"
                                    data-search="<span class='fa fa-search' style='color: #fff;background: #31708f;'></span>"
                                    data-loading="<i class='fa fa-circle-o-notch fa-spin'></i> Buscando"
                                    class="btn btn-default"
                                    data-url="{{route('persona.dato.personal','paciente')}}"
                                    title="buscar..." style="color: #fff;background: #31708f; font-size: 15px">
                                <span class="fa fa-search" style="color: #fff;background: #31708f;"></span>
                            </button>
                        </div>
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

        var load_analisis_url ="{{route('load.analisis.table','persona_id')}}";


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

        $(document).on('click',"#btn-nuevo",function (e) {
            e.preventDefault();

            if($(this).is(":disabled")) return false;
            var url = $(this).data('url').replace('persona_id',params.persona.id);
            var btn_nuevo = $(this);

            $.ajax({
                url: url,
                type:'get',
                data: {persona_id : params.persona.id},
                success: function (view) {
                    var dialog = bootbox.dialog({
                        title: "<b>Nuevo análisis</b>",
                        message: view,
                        size: 'large',
                        buttons: {
                            cancel: {
                                label: "CANCELAR",
                                className: 'btn btn-sm btn-default',
                            },
                            ok: {
                                label: "GUARDAR",
                                className: 'btn btn-default btn-sm btn-info btn-guardar-nuevo',
                                callback: function(){

                                    if(motivosArr.length<=0 || $("input[name=medico_id]").length<=0) return false;

                                    var form = $("#form-store");

                                    var url = form.attr('action');
                                    var btn = $(".btn-guardar-nuevo");

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
                    $(".input-numeric").inputFilter(function (value) {
                        return format_numeric(value);
                    });
                    /*Numeros sin decimal*/
                    $(".input-digits").inputFilter(function (value) {
                        return format_digits(value);
                    });

                }
            });

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
                                beforeSend: function () {
                                    btn.html("<i class='fa  fa-circle-o-notch fa-spin'> </i> ESPERE");
                                    btn.attr('disabled',true);
                                },complete: function () {
                                    btn.html('CONFIRMAR');
                                    btn.removeAttr('disabled');
                                    load_table();
                                }
                            });
                            return false;
                        }
                    }
                }
            });
        });

        $(document).on("click","a", function (e) {
            if($(this).parent().parent().hasClass('pagination')){
                if($(this).hasClass('disabled')) return  false;
                $(this).addClass('disabled');
                load_table($(this).attr('href'));
                return false;
            }

        });
        function load_table(paginate_url){
            var url=paginate_url;
            if(paginate_url==undefined){
                url =load_analisis_url;
                url = url.replace('persona_id',params.persona.id)
            }

            $.ajax({
                url:url ,
                type:'get',
                success: function (view) {
                    $("#registros-analisis").html(view);
                }
            });
        }
        var params={};
        $("#btn-consultar").on('click', function (event, data) {

            if ($("#txt-numero").val() == ""){
                return false;
            }
            var url = $(this).data('url');
            $('#message').html('');
            var btn = $(this);
            params.numero_documento = $("#txt-numero").val();
            $.ajax({
                url: url,
                type: 'get',
                data: params,
                success: function (view){
                    $("#main-section").html(view);
                    $('#main-section').fadeIn();
                    $('#search-section').fadeOut();
                    params.persona = JSON.parse($("#hdh-persona").val());
                    console.log(params);
                    if(params.persona.tipo_persona=='paciente'){
                        load_analisis();
                    }
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


        /** load analisis*/
        function load_analisis(){
            var url_temporal =load_analisis_url.replace('persona_id',params.persona.id);
            $.get(url_temporal,function (view) {
                $("#registros-analisis").html(view);
            });

        }



        $(document).on('click','.btn-ver-resultados',function () {
            var url = $(this).data('url');
            $.get(url,function (view) {
                var dialog = bootbox.dialog({
                    title: "<b>Resultados de análisis</b>",
                    message: view,
                    size: 'large',
                    buttons: {
                        cancel: {
                            label: "CERRAR",
                            className: 'btn btn-sm btn-default',
                            callback: function(){
                                return true;
                            }
                        },
                    }
                });
                $(".input-numeric").inputFilter(function (value) {
                    return format_numeric(value);
                });
            });
        });
        $(document).on('click','.btn-cabiar-paciente',function () {
            var url = $(this).data('url');
            $.get(url,function (view) {
                var dialog = bootbox.dialog({
                    title: "<b>Mover análisis</b>",
                    message: view,
                    size: 'medium',
                    buttons: {
                        cancel: {
                            label: "CERRAR",
                            className: 'btn btn-sm btn-default',
                            callback: function(){
                                return true;
                            }
                        },
                        ok: {
                            label : 'MOVER ANÁLISIS',
                            className: 'btn btn-sm btn-info',
                            callback: function () {

                                var form = $("#form-cambiar-paciente");
                                if(!$("#form-cambiar-paciente input[name=paciente_id]").val()) return false;
                                var url = form.attr('action');
                                $.ajax({
                                    url : url,
                                    type : 'put',
                                    data: form.serializeArray(),
                                    beforeSend: function () {

                                    },complete: function () {
                                        load_table();
                                    }

                                });
                            }
                        }
                    }
                });
            });
        });

    </script>
@endsection
